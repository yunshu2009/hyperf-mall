<?php

declare(strict_types=1);

namespace App\Service\Api\Pms;

interface BrandServiceInterface
{
    public function recommendList(int $pageNum, int $pageSize) : array;
}
