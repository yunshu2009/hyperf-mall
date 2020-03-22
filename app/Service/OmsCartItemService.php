<?php
declare(strict_types=1);

namespace App\Service;

use App\Constants\ResultCode;
use App\Exception\BusinessException;
use App\Model\UmsMember;
use App\Model\OmsCartItem;
use Hyperf\Di\Annotation\Inject;

class OmsCartItemService  extends Service implements OmsCartItemServiceInterface
{
    /**
     * @Inject()
     * @var \App\Service\PmsProductServiceInterface
     */
    private $pmsProductService;

    /**
     * @Inject()
     * @var \App\Service\PmsSkuStockServiceInterface
     */
    private $pmsProductSkuService;

    /**
     * @Inject()
     * @var \App\Service\OmsPromotionService
     */
    private $promotionService;

    /**
     * @Inject()
     * @var \App\Dao\ProductDao $productDao
     */
    private $productDao;

    public function add(array $cartItem, UmsMember $member) : array
    {
        $cartItem['member_id'] = $member->id;
        $cartItem['member_nickname'] = $member->nickname;

        $product = $this->pmsProductService->getItem($cartItem['product_id']);
        if (! $product) {
            throw new BusinessException(ResultCode::FAILED, '商品不存在');
        }
        $cartItem['product_name'] = $product['name'];
        $cartItem['product_pic'] = $product['pic'];
        $cartItem['price'] = $product['price'];
        $cartItem['product_sub_title'] = $product['sub_title'];
        $cartItem['product_category_id'] = $product['product_category_id'];
        $cartItem['product_brand'] = $product['product_brand'];
        $cartItem['product_sn'] = $product['product_sn'];
        $cartItem['product_brand'] = $product['brand_name'];
        $productSku = $this->pmsProductSkuService->getItem($cartItem['product_sku_id']);
        if (! $productSku) {
            throw new BusinessException(ResultCode::FAILED, '商品不存在');
        }
        $cartItem['product_sku_code'] = $productSku['sku_code'];

        $existCartItem = $this->getCartItem($cartItem);

        if (is_null($existCartItem)) {
            $cartItem = OmsCartItem::create($cartItem);
            $cartItem = $cartItem->toArray();
        } else {
            $cartItem['quantity'] = $existCartItem['quantity'] + $cartItem['quantity'];
            OmsCartItem::where('id', $existCartItem['id'])->update($cartItem);
        }

        return $cartItem;
    }

    public function getCartItem(array $cartItem) : ?OmsCartItem
    {
        $where['member_id'] = $cartItem['member_id'];
        $where['product_id'] = $cartItem['product_id'];
        $where['product_sku_id'] = $cartItem['product_sku_id'];

        return OmsCartItem::where($where)->first();
    }

    public function listPromotion(int $memberId)
    {
        // 获取用户的购物车列表
        $cartItemList = $this->list($memberId);
        $cartPromotionItemList = [];
        if (! empty($cartItemList)) {
            $cartPromotionItemList = $this->promotionService->calcCartPromotion($cartItemList);
        }

        return $cartPromotionItemList;
    }

    public function list(int $memberId) : array
    {
        $list = OmsCartItem::where('member_id', $memberId)
                          ->get()
                          ->toArray();

        return $this->transform($list);
    }

    public function updateQuantity($memberId, $id, $quantity)
    {
        return OmsCartItem::where('id', $id)->where('member_id', $memberId)->update([
            'quantity'=>$quantity,
        ]);
    }

    public function delete($memberId, $ids)
    {
       return OmsCartItem::whereIn('id', $ids)->where('member_id', $memberId)->delete();
    }

    public function clear($memberId)
    {
        return OmsCartItem::where('member_id', $memberId)->delete();
    }

    public function updateAttr($memberId, $cartItem)
    {
        // 删除原购物车信息

        // 添加购物车信息

        return 1;
    }

    public function getCartProduct($productId)
    {
        return $this->productDao->getCartProduct($productId);
    }
}
