<?php
declare(strict_types=1);

namespace App\Service\Api;

use App\Model\UmsMember;

interface MemberCouponServiceInterface
{
    /**
     * 会员添加优惠券
     */
    public function add(int $couponId, UmsMember $member) : bool;

    /**
     * 获取优惠券列表
     */
    public function list(int $useStatus, UmsMember $member) : array;

     /**
     * 根据购物车信息获取可用优惠券
     */
    public function listCart(array $cartPromotionItemList, int $type, UmsMember $member) : array;
}
