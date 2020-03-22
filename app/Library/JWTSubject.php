<?php

declare(strict_types=1);

namespace App\Library;

interface JWTSubject
{
    /**
     * 查询主键
     *
     * @return mixed
     */
    public function getJWTIdentifier();
}