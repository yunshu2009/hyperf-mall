<?php
declare(strict_types=1);

namespace App\Service\Api\Ums;

interface MemberServiceInterface
{
    public function login(string $username, string $password) : string;

    public function refreshToken(string $token) : string;

    public function generateAuthCode(string $telephone) : string;

    public function updatePassword(string $telephone, string $password, string $authCode) : bool;
}
