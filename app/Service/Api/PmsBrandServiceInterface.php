<?php

declare(strict_types=1);

namespace App\Service\Api;

interface PmsBrandServiceInterface
{
    public function recommendList(int $pageNum, int $pageSize) : array;
}
