<?php

declare(strict_types=1);

namespace App\Controller\Api\Ums;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户优惠券管理
 * Class MemberCouponController
 * @Controller(prefix="member/coupon")
 * @package App\Controller\Portal
 */
class MemberCouponController extends \App\Controller\Controller
{
    /**
     * @Inject()
     * @var \App\Service\Api\MemberCouponServiceInterface
     */
    private $memberCouponService;

    /**
     * @Inject()
     * @var \App\Service\Api\Oms\CartItemServiceInterface
     */
    private $cartItemService;

    /**
     * 领取指定优惠券
     * @RequestMapping(path = "add/{couponId}", method = "post")
     */
    public function add(int $couponId) : ResponseInterface
    {
        $member = $this->member();
        $this->memberCouponService->add($couponId, $member);

        return $this->success([]);
    }

    /**
     * 获取优惠券列表
     * @RequestMapping(path = "list", method = "get")
     */
    public function list()
    {
        // useStatus 优惠券筛选类型:0->未使用；1->已使用；2->已过期
        $useStatus = $this->request->input('useStatus', 0);
        if (! in_array($useStatus, [0, 1, 2])) {
            return $this->error('参数错误');
        }

        $member = $this->member();

        $list = $this->memberCouponService->list($useStatus, $member);

        return $this->success($list);
    }

    /**
     * 获取登录会员购物车的相关优惠券 使用可用:0->不可用；1->可用
     * @RequestMapping(path = "list/cart/{type}", method = "get")
     */
    public function listCart(int $type)
    {
        if (! in_array($type, [0, 1])) {
            return $this->error('参数错误');
        }

        $member = $this->member();

        $cartPromotionItemList = $this->cartItemService->listPromotion($member->id);
        $couponHistoryList = $this->memberCouponService->listCart($cartPromotionItemList, $type, $member);

        return $this->success($couponHistoryList);
    }
}
