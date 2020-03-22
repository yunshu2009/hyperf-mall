<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\PmsSkuStock;
use Psr\Http\Message\ResponseInterface;

class PmsSkuStockService extends Service implements PmsSkuStockServiceInterface
{
    public function getList(int $pid, string $keyword) : array
    {
        return [];
    }

    public function update(int $pid, array $skuStockList) : int
    {
        return 0;
    }

    public function getItem(int $id) : ?PmsSkuStock
    {
        return PmsSkuStock::where('id', $id)->first();
    }
}