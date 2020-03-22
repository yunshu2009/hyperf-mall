<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $name 
 * @property int $type 轮播位置：0->PC首页轮播；1->app首页轮播
 * @property string $pic 
 * @property string $start_time 
 * @property string $end_time 
 * @property int $status 上下线状态：0->下线；1->上线
 * @property int $click_count 点击数
 * @property int $order_count 下单数
 * @property string $url 链接地址
 * @property string $note 备注
 * @property int $sort 排序
 */
class SmsHomeAdvertise extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_home_advertise';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'pic', 'start_time', 'end_time', 'status', 'click_count', 'order_count', 'url', 'note', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'type' => 'integer', 'status' => 'integer', 'click_count' => 'integer', 'order_count' => 'integer', 'sort' => 'integer'];

    public $timestamps = false;
}