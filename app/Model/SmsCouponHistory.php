<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $coupon_id 
 * @property int $member_id 
 * @property string $coupon_code 
 * @property string $member_nickname 领取人昵称
 * @property int $get_type 获取类型：0->后台赠送；1->主动获取
 * @property int $use_status 使用状态：0->未使用；1->已使用；2->已过期
 * @property int $order_id 订单编号
 * @property string $order_sn 订单号码
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $use_time 使用时间
 */
class SmsCouponHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_coupon_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['coupon_id', 'member_id', 'coupon_code', 'member_nickname', 'get_type', 'use_status', 'order_id', 'order_sn', 'use_time'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'coupon_id' => 'integer', 'member_id' => 'integer', 'get_type' => 'integer', 'use_status' => 'integer', 'order_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}