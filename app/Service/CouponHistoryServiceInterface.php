<?php

declare(strict_types=1);

namespace App\Service;

interface CouponHistoryServiceInterface
{
    public function list($pageSize, $pageNum, ...$condition) : array;
}