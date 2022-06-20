<?php

namespace App\Service\Api\Oms;

use App\Service\Service;
use Hyperf\Di\Annotation\Inject;

class PortalOrderService extends Service implements OmsPortalOrderServiceInterface
{
    /**
     * @Inject()
     * @var \App\Service\Api\Oms\CartItemServiceInterface
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
