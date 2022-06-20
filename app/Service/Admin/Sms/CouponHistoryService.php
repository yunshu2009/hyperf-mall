<?php

declare(strict_types=1);

namespace App\Service\Admin\Sms;

use App\Service\Service;

class CouponHistoryService extends Service implements CouponHistoryServiceInterface
{
    public function list($pageSize, $pageNum, ...$condition) : array
    {
        return [];
    }
}
