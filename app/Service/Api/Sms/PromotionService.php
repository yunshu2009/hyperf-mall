<?php

declare(strict_types=1);

namespace App\Service\Api\Sms;

use App\Service\Service;
use Hyperf\Di\Annotation\Inject;

class PromotionService extends Service implements PromotionServiceInterface
{
    /**
     * @Inject()
     * @var \App\Dao\ProductDao
     */
    private $productDao;

    public function calcCartPromotion(array $cartItemList)
    {
        $cartPromotionItemList = [];
        // 1.先根据productId对CartItem进行分组，以spu为单位进行计算优惠
        $productCartMap = $this->groupCartItemBySpu($cartItemList);
        // 2.查询所有商品的优惠相关信息
        $promotionProductList = $this->getPromotionProductList($cartItemList);
        // 3.根据商品促销类型计算商品促销优惠价格
        $cartPromotionItemList = [];
        foreach ($productCartMap as $productId=>$itemList) {
            $promotionProduct = $this->getPromotionProductById((int)$productId, $promotionProductList);
            $promotionType = $promotionProduct['promotion_type'];
            if ($promotionType == 1) { // 单品促销
                foreach ($itemList as $item) {
                    $cartPromotionItem = $item;
                    $cartPromotionItem['promotionMessage'] = '单品促销';
                    $skuStock = $this->getOriginalPrice($promotionProduct, $item['product_sku_id']);
                    $originalPrice = $skuStock['price'];

                    $cartPromotionItem['reduceAmount'] = $originalPrice-$skuStock['promotion_price'];
                    $cartPromotionItem['realStock'] = $skuStock['stock'] - $skuStock['lockstock'];
                    $cartPromotionItem['integration'] = $promotionProduct['gift_point'];
                    $cartPromotionItem['growth'] = $promotionProduct['growth'];
                    $cartPromotionItemList[] = $cartPromotionItem;
                }
            } elseif ($promotionType == 3) { // 打折优惠
                $count = $this->getCartItemCount($itemList);
                $ladder = $this->getProductLadder($count, $promotionProduct['ladderList']);
                if ($ladder != null) {
                    foreach ($itemList as $cartItem) {
                        $cartPromotionItem = $cartItem;
                        $cartPromotionItem['promotionMessage'] = $this->getLadderPromotionMessage($ladder);
                        // 差价 = 商品原价-折扣*商品原价
                        $skuStock = $this->getOriginalPrice($promotionProduct, $cartItem['product_sku_id']);
                        $originalPrice = $skuStock['price'];
                        $cartPromotionItem['reduceAmount'] = $skuStock['price'] - $ladder['discount'] * $originalPrice;        $cartPromotionItem['realStock'] = $skuStock['stock'] - $skuStock['lockstock'];
                        $cartPromotionItem['integration'] = $promotionProduct['gift_point'];
                        $cartPromotionItem['growth'] = $promotionProduct['gift_growth'];
                        $cartPromotionItemList[] = $cartPromotionItem;
                    }
                } else {  // 无优惠
                    $this->handleNoReduce($cartPromotionItemList, $itemList, $promotionProduct);
                }
            } elseif ($promotionType == 4) { // 满减
                $totalAmount = $this->getCartItemAmount($itemList, $promotionProductList);
                $fullReduction = $this->getProductFullReduction($totalAmount, $promotionProduct['productFullReductionList']);
                if (! is_null($fullReduction)) {
                    foreach ($itemList as $item) {
                        $cartPromotionItem = [];
                        $message = $this->getFullReductionPromotionMessage($fullReduction);
                        $cartPromotionItem['promotionMessage'] = $message;
                        $skuStock = $this->getOriginalPrice($promotionProduct, $item['product_sku_id']);
                        $originalPrice = $skuStock['price'];
                        $reduceAmount = round((float)bcmul((float)bcdiv($originalPrice, $totalAmount, 3), $fullReduction['reduce_price'], 3), 2);
                        $cartPromotionItem['reduceAmount'] = $reduceAmount;
                        $cartPromotionItem['realStock'] = $skuStock['lock'] - $skuStock['lockstock'];
                        $cartPromotionItem['integration'] = $promotionProduct['gift_point'];
                        $cartPromotionItem['growth'] = $promotionProduct['gift_growth'];
                        $cartPromotionItemList[] = $cartPromotionItem;
                    }
                } else {
                    $this->handleNoReduce($cartPromotionItemList, $itemList, $promotionProduct);
                }
            } else { // 无优惠
                $this->handleNoReduce($cartPromotionItemList, $itemList, $promotionProduct);
            }
        }

        return $cartPromotionItemList;
    }

    private function getFullReductionPromotionMessage(array $fullReduction)
    {
        $message = '';
        $message .= '满减优惠：';
        $message .= '满';
        $message .= $fullReduction['full_price'];
        $message .= '元';
        $message .= '减';
        $message .= $fullReduction['reduce_price'];
        $message .= '元';

        return $message;
    }

    private function getProductFullReduction(float $totalAmount, array $fullReductionList) : ?array
    {
        $order_array = array_column($fullReductionList, 'full_price');
        array_multisort($order_array, SORT_DESC, $fullReductionList);

        foreach ($fullReductionList as $fullReduction) {
            if ($totalAmount-$fullReduction['full_price'] >= 0) {
                return $fullReduction;
            }
        }

        return null;
    }

    private function getCartItemAmount($itemList, $promotionProductList)
    {
        $amount = 0;
        foreach ($itemList as $item) {
            // 计算出商品原价
            $promotionProduct = $this->getPromotionProductById($item['product_id'], $promotionProductList);
            $skuStock = $this->getOriginalPrice($promotionProduct, $item['product_sku_id']);
            $amount += bcmul($skuStock['price'], $item['quantity'], 2); // 商品总价
        }

        return $amount;
    }

    private function getLadderPromotionMessage(array $ladder)
    {
        $str = '';
        $str .= "打折优惠：";
        $str .= "满";
        $str .= $ladder['count'];
        $str .= '件，';
        $str .= '打';
        $str .= $ladder['discount'] * 10;
        $str .= '折';

        return $str;
    }

    /**
     * 对没满足优惠条件的商品进行处理
     */
    private function handleNoReduce(array &$cartPromotionItemList, array $itemList, array $promotionProduct)
    {
        foreach ($itemList as $item) {
            $cartPromotionItem = $item;
            $cartPromotionItem['promotionMessage'] = '无优惠';
            $cartPromotionItem['reduceAmount'] = 0;  //
            $skuStock = $this->getOriginalPrice($promotionProduct, $item['product_sku_id']);
            if ($skuStock) {
                $cartPromotionItem['realStock'] = $skuStock['stock'] - $skuStock['lock_stock'];
            }
            $cartPromotionItem['integration'] = $promotionProduct['gift_point'];
            $cartPromotionItem['growth'] = $promotionProduct['gift_growth'];
            $cartPromotionItemList[] = $cartPromotionItem;
        }
    }

    /**
     * 根据购买商品数量获取满足条件的打折优惠策略
     * @param int   $count
     * @param array $productLadderList
     */
    private function getProductLadder(int $count, array $productLadderList) : ?array
    {
        // 按数量从大到小排序
        array_multisort($productLadderList, 'count', SORT_DESC);

        foreach ($productLadderList as $productLadderItem) {
            if ($count >= $productLadderItem['count']) {
                return $productLadderItem;
            }
        }

        return null;
    }

    /**
     * 获取购物车中指定商品的数量
     * @param array $cartItemList
     */
    private function getCartItemCount(array $cartItemList)
    {
        $count = 0;

        foreach ($cartItemList as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    private function getOriginalPrice($promotionProduct, $productSkuId)
    {
        foreach ($promotionProduct['skuStockList'] as $skuStock) {
            if ($productSkuId == $skuStock['id']) {
                return $skuStock;
            }
        }

        return null;
    }

    private function getPromotionProductList(array $cartItemList)
    {
        $productIdList = [];
        foreach ($cartItemList as $cartItem) {
            $productIdList[] = $cartItem['product_id'];
        }

        return $this->productDao->getPromotionProductList($productIdList);
    }

    private function groupCartItemBySpu(array $cartItemList)
    {
        $productCartMap = [];

        foreach ($cartItemList as $cartItem) {
            if (! isset($productCartMap[$cartItem['product_id']])) {
                $productCartMap[$cartItem['product_id']] = [];
            }
            $productCartMap[$cartItem['product_id']][] = $cartItem;
        }

        return $productCartMap;
    }

    /**
     * 根据商品id获取商品的促销信息
     */
    private function getPromotionProductById(int $productId, array $promotionProductList) :?array
    {
        foreach ($promotionProductList  as $promotionProduct) {
            if ($productId == $promotionProduct['id']) {
                return $promotionProduct;
            }
        }

        return null;
    }
}
