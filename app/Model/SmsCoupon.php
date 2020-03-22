<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $type 优惠卷类型；0->全场赠券；1->会员赠券；2->购物赠券；3->注册赠券
 * @property string $name 
 * @property int $platform 使用平台：0->全部；1->移动；2->PC
 * @property int $count 数量
 * @property float $amount 金额
 * @property int $per_limit 每人限领张数
 * @property float $min_point 使用门槛
 * @property string $start_time 
 * @property string $end_time 
 * @property int $use_type 使用类型：0->全场通用；1->指定分类；2->指定商品
 * @property string $note 备注
 * @property int $publish_count 发现数量
 * @property int $use_count 已使用数量
 * @property int $receive_count 领取数量
 * @property string $enable_time 可以领取的日期
 * @property string $code 优惠码
 * @property int $member_level 可领取的会员类型：0->无限时
 */
class SmsCoupon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_coupon';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'name', 'platform', 'count', 'amount', 'per_limit', 'min_point', 'start_time', 'end_time', 'use_type', 'note', 'publish_count', 'use_count', 'receive_count', 'enable_time', 'code', 'member_level'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'type' => 'integer', 'platform' => 'integer', 'count' => 'integer', 'amount' => 'float', 'per_limit' => 'integer', 'min_point' => 'float', 'use_type' => 'integer', 'publish_count' => 'integer', 'use_count' => 'integer', 'receive_count' => 'integer', 'member_level' => 'integer'];

    public $timestamps = false;
}