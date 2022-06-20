<?php
declare(strict_types=1);

namespace App\Service\Admin\Sms;

use App\Model\SmsFlashPromotion;
use App\Service\Service;

class FlashPromotionService extends Service implements FlashPromotionServiceInterface
{
    public function create(array $flashPromotionParam) : ?SmsFlashPromotion
    {
        return null;
    }

    public function update(int $id, array $flashPromotionParam) : int
    {
        return 0;
    }

    public function delete(int $id) : int
    {
        return 0;
    }

    public function updateStatus(int $id, int $status) : int
    {
        return 0;
    }

    public function getItem(int $id) : ?SmsFlashPromotion
    {
        return null;
    }

    public function getList(int $pageSize, int $pageNum, array $condition) : array
    {
        return [];
    }
}
