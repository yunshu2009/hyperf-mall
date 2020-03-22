<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Model;

use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\Utils\Str;

abstract class Model extends BaseModel
{
    //  访问时使用驼峰法
    public function getAttribute($key)
    {
        $key = Str::snake($key);

        return parent::getAttribute($key);
    }
}
