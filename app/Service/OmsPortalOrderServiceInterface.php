<?php

namespace App\Service;

interface OmsPortalOrderServiceInterface
{
    public function generateConfirmOrder($member) : array;
}