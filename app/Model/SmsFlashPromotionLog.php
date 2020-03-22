<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $member_id 
 * @property int $product_id 
 * @property string $member_phone 
 * @property string $product_name 
 * @property string $subscribe_time 会员订阅时间
 * @property string $send_time 
 */
class SmsFlashPromotionLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_flash_promotion_log';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['member_id', 'product_id', 'member_phone', 'product_name', 'subscribe_time', 'send_time'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'member_id' => 'integer', 'product_id' => 'integer'];

    public $timestamps = false;
}