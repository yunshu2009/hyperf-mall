<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\SmsCoupon;
use Psr\Http\Message\ResponseInterface;

class SmsCouponService extends Service implements SmsCouponServiceInterface
{
    public function create($couponParam) : ?SmsCoupon
    {
        return null;
    }

    public function delete(int $id) : int
    {
        return 0;
    }

    public function update(int $id, array $couponParam) : int
    {
        return 0;
    }

    public function list(int $pageSize, int $pageNum, array $condition) : array
    {
        return [];
    }

    public function getItem(int $id) : ?SmsCoupon
    {
        return null;
    }
}