<?php
declare(strict_types=1);

namespace App\Service\Admin\Sms;

use App\Model\SmsCoupon;

interface CouponServiceInterface
{
    public function create(array $couponParam) : ?SmsCoupon;

    public function delete(int $id) : int;

    public function update(int $id, array $couponParam) : int;

    public function list(int $pageSize, int $pageNum, array $condition) : array;

    public function getItem(int $id) : ?SmsCoupon;
}
