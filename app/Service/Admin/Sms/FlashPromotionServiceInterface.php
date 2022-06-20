<?php
declare(strict_types=1);

namespace App\Service\Admin\Sms;

use App\Model\SmsFlashPromotion;

interface FlashPromotionServiceInterface
{
    public function create(array $flashPromotionParam) : ?SmsFlashPromotion;

    public function update(int $id, array $flashPromotionParam) : int;

    public function delete(int $id) : int;

    public function updateStatus(int $id, int $status) : int;

    public function getItem(int $id) : ?SmsFlashPromotion;

    public function getList(int $pageSize, int $pageNum, array $condition) : array;
}
