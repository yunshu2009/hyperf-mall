<?php
declare(strict_types=1);

namespace App\Service\Api\Oms;

use App\Model\UmsMember;

interface CartItemServiceInterface
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
