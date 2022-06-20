<?php
declare(strict_types=1);

namespace App\Service\Api\Ums;

use App\Model\UmsMember;
use App\Model\UmsMemberReceiveAddress;
use App\Service\Service;

class MemberReceiveAddressService extends Service implements MemberReceiveAddressServiceInterface
{
    public function add(array $address, UmsMember $member) : UmsMemberReceiveAddress
    {
        $address['member_id'] = $member->id;
        $address = UmsMemberReceiveAddress::create($address);

        return $address;
    }

    public function delete(int $id, UmsMember $member) : int
    {
        return UmsMemberReceiveAddress::where('id', $id)
                                  ->where('member_id', $member->id)
                                  ->delete($id);
    }

    public function update(int $id, array $address, UmsMember $member) : int
    {
        if (isset($address['member_id'])) unset($address['member_id']);
        if (isset($address['id'])) unset($address['id']);

        return UmsMemberReceiveAddress::where('id', $id)
                                      ->where('member_id', $member->id)
                                      ->update($address);
    }

    public function list(UmsMember $member) : array
    {
        $list = UmsMemberReceiveAddress::where('member_id', $member->id)
                                      ->get()
                                      ->toArray();

        return $this->transform($list);
    }

    public function getItem(int $id, UmsMember $member) : array
    {
        $address = UmsMemberReceiveAddress::where('member_id', $member->id)
                                       ->where('id', $id)
                                       ->first();
        if (! $address) {
            return [];
        }

        return $this->transform($address->toArray());
    }
}
