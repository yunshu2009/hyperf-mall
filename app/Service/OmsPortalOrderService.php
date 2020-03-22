<?php

namespace App\Service;

use Hyperf\Di\Annotation\Inject;

class OmsPortalOrderService extends Service implements OmsPortalOrderServiceInterface
{
    /**
     * @Inject()
     * @var \App\Service\OmsCartItemServiceInterface
     */
    private $cartItemService;

    public function generateConfirmOrder($member) : array
    {
        $confirmOrderRes = array();

        // 获取优惠信息
        $cartPromotionItemList = $this->cartItemService->listPromotion($member['id']);
        $confirmOrderRes['cartPromotionItemList'] = $cartPromotionItemList;

        return $confirmOrderRes;
    }
}