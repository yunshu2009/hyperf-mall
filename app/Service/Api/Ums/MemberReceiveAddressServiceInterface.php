<?php
declare(strict_types=1);

namespace App\Service\Api\Ums;

use App\Model\UmsMember;
use App\Model\UmsMemberReceiveAddress;

interface MemberReceiveAddressServiceInterface
{
    public function add(array $address, UmsMember $member) : UmsMemberReceiveAddress;

    public function delete(int $id, UmsMember $member) : int;

    public function update(int $id, array $address, UmsMember $member) : int;

    public function list(UmsMember $member) : array;

    public function getItem(int $id,  UmsMember $member) : array;
}
