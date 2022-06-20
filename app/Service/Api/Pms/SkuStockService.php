<?php
declare(strict_types=1);

namespace App\Service\Api\Pms;

use App\Model\PmsSkuStock;
use App\Service\Service;

class SkuStockService extends Service implements SkuStockServiceInterface
{
    public function getList(int $pid, string $keyword) : array
    {
        return [];
    }

    public function update(int $pid, array $skuStockList) : int
    {
        return 0;
    }

    public function getItem(int $id) : object
    {
        return PmsSkuStock::where('id', $id)->first();
    }
}
