<?php

declare(strict_types=1);

namespace App\Service\Admin\Sms;

interface CouponHistoryServiceInterface
{
    public function list($pageSize, $pageNum, ...$condition) : array;
}
