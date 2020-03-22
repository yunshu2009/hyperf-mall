<?php

declare(strict_types=1);

namespace App\Service;

interface OmsPromotionServiceInterface
{
    public function calcCartPromotion(array $cartItemList);
}