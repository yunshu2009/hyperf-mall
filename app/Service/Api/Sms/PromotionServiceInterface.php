<?php

declare(strict_types=1);

namespace App\Service\Api\Sms;

interface PromotionServiceInterface
{
    public function calcCartPromotion(array $cartItemList);
}
