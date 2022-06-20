<?php
declare(strict_types=1);

namespace App\Service\Admin\Pms;

interface SkuStockServiceInterface
{
    public function getList(int $pid, string $keyword) : array;

    public function update(int $pid, array $skuStockList) : int;

    public function getItem(int $id) : object;
}
