<?php
declare(strict_types=1);

namespace App\Service\Api;

use App\Constants\ResultCode;
use App\Exception\BusinessException;
use App\Model\SmsCoupon;
use App\Model\SmsCouponHistory;
use App\Model\UmsMember;
use App\Service\Service;
use Hyperf\Di\Annotation\Inject;
use Hyperf\DbConnection\Db;

class MemberCouponService extends Service implements MemberCouponServiceInterface
{
    /**
     * @Inject()
     * @var \App\Dao\CouponHistoryDao
     */
    private $couponHistoryDao;

    public function add(int $couponId, UmsMember $member) : bool
    {
        try {
            Db::beginTransaction();
            //获取优惠券信息，判断数量
            $coupon = SmsCoupon::where('id', $couponId)->first();

            if (! $coupon) {
                throw new BusinessException(ResultCode::FAILED, '优惠券不存在');
            }

            if ($coupon->count <= 0) {
                throw new BusinessException(ResultCode::FAILED, '优惠券已经领完了');
            }

            if (time() < strtotime($coupon->enable_time)) {
                throw new BusinessException(ResultCode::FAILED, '优惠券还没到领取时间');
            }

            // 判断用户领取的优惠券数量是否超过限制
            $count = SmsCouponHistory::where('coupon_id', $couponId)
                                     ->where('member_id', $member->id)
                                     ->count();
            if ($count >= $coupon->per_limit) {
                throw new BusinessException(ResultCode::FAILED, '您已经领取过该优惠券');
            }

            //生成领取优惠券历史
            $couponHistory                     = [];
            $couponHistory['coupon_id']        = $couponId;
            $couponHistory['coupon_code']
                                               = $this->generateCouponCode($member->id);
            $couponHistory['member_id']        = $member->id;
            $couponHistory['member_nickname'] = $member->nickname;
            $couponHistory['get_type']         = 1; // 主动领取
            $couponHistory['use_status']       = 0;
            SmsCouponHistory::create($couponHistory);

            // 修改优惠券表的数量、领取数量
            $coupon->count         = $coupon->count - 1;
            $coupon->receive_count = is_null($coupon->receive_count) ? 1
                : $coupon->receive_count + 1;
            $coupon->save();
            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * 16位优惠码生成：时间戳后8位+4位随机数+用户id后4位
     */
    private function generateCouponCode(int $memberId) : string
    {
        $millisecond = get_milli_second();

        return substr((string)$millisecond, -8) . sprintf('%04d', mt_rand(0, 9999)) . sprintf('%04d', substr((string)$memberId, -4));
    }

    public function list(int $useStatus, UmsMember $member) : array
    {
        $list = SmsCouponHistory::where('member_id', $member->id)
                ->where('use_status', $useStatus)
                ->get()
                ->toArray();

        return $this->transform($list);
    }

    public function listCart(array $cartItemList, int $type, UmsMember $member) : array
    {
        // 1. 获取该用户所有优惠券
        $allList = $this->couponHistoryDao->getDetailList($member->id);
        // 2. 根据优惠券使用类型来判断优惠券是否可用 （循环优惠券）
        $enableList = [];
        $disableList = [];

        foreach ($allList as $item) {
            $useType = $item['coupon']['use_type'];
            $minPoint = $item['coupon']['min_point'];
            $endTime = $item['coupon']['end_time'];

            if ($useType == 0) { // 0->全场通用
                // 计算购物车的商品总价
                $totalAmount = $this->calcTotalAmount($cartItemList);
                if (time()<strtotime($endTime) && (float)bcsub($totalAmount, $minPoint, 2) > 0) {
                    $enableList[] = $item;
                } else {
                    $disableList[] = $item;
                }
            } elseif ($useType == 1) { // 1->指定分类
                $productCategoryIds = [];
                $categoryRelationList = $item['categoryRelationList'];

                foreach ($categoryRelationList as $categoryRelation) {
                    $productCategoryIds[] = $categoryRelation['productCategoryId'];
                }
                $totalAmount = $this->calcTotalAmountByproductCategoryId($cartItemList, $productCategoryIds);
                if(time()<strtotime($endTime) && $totalAmount>0 && (float)bcsub($totalAmount, $minPoint, 2) > 0) {
                    $enableList[] = $item;
                }else{
                    $disableList[] = $item;
                }
            } else { // 2->指定商品
                $productIds = [];
                $productRelationList = $item['productRelationList'];
                foreach ($productRelationList as $productRelation) {
                    $productIds[] = $productRelation['product_id'];
                }
                // 计算关联商品总价
                $totalAmount = $this->calcTotalAmountByProductId($cartItemList, $productIds);
                if(time()<strtotime($endTime) && $totalAmount>0 && (float)bcsub($totalAmount, $minPoint, 2) > 0) {
                    $enableList[] = $item;
                }else{
                    $disableList[] = $item;
                }
            }
        }

        if ($type == 1) {
            return $this->transform($enableList);
        } else {
            return $this->transform($disableList);
        }
    }

    private function calcTotalAmountByproductCategoryId(array $cartItemList, array $productCategoryIds) : float
    {
        $total = 0;
        foreach ($cartItemList as $cartItem) {
            if (in_array($cartItem['product_category_id'], $productCategoryIds)) {
                $realPrice = $cartItem['price'] - $cartItem['reduce_amount'];
                $total += $realPrice * $cartItem['quantity'];
            }
        }

        return $total;
    }

    private function calcTotalAmountByProductId(array $cartItemList, array $productIds) : float
    {
        $total = 0;
        foreach ($cartItemList as $cartItem) {
            if (in_array($cartItem['product_id'], $productIds)) {
                $realPrice = $cartItem['price'] - $cartItem['reduce_amount'];
                $total += $realPrice * $cartItem['quantity'];
            }
        }

        return $total;
    }

    private function calcTotalAmount(array $cartItemList) : float
    {
        $total = 0;
        foreach ($cartItemList as $cartItem) {
            $realPrice = $cartItem['price'] - $cartItem['reduce_amount'];
            $total += $realPrice * $cartItem['quantity'];
          }

        return $total;
    }
}
