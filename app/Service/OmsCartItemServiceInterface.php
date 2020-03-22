<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\OmsCartItem;
use App\Model\UmsMember;

interface OmsCartItemServiceInterface
{
    public function add(array $cartItem, UmsMember $member) : array;

    public function listPromotion(int $memberId);

    public function list(int $memberId) : array;

    public function updateQuantity($memberId, $id, $quantity);

    public function delete($memberId, $ids);

    public function clear($memberId);

    public function updateAttr($memberId, $cartItem);

    public function getCartProduct($productId);
}
