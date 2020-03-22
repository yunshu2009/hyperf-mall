<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\PmsSkuStock;

interface PmsSkuStockServiceInterface
{
    public function getList(int $pid, string $keyword) : array;

    public function update(int $pid, array $skuStockList) : int;

    public function getItem(int $id) : ?PmsSkuStock;
}