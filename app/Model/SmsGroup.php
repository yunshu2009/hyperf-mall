<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class SmsGroup extends Model
{
    protected $table = 'sms_group';

    public function goods()
    {
        return $this->belongsTo(PmsProduct::class, 'goods_id', 'id');
    }
}
