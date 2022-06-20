<?php

namespace App\Service\Api\Oms;

interface PortalOrderServiceInterface
{
    public function generateConfirmOrder($member) : array;
}
