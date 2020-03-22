<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 编号
 * @property string $name 场次名称
 * @property string $start_time 每日开始时间
 * @property string $end_time 每日结束时间
 * @property int $status 启用状态：0->不启用；1->启用
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class SmsFlashPromotionSession extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_flash_promotion_session';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'start_time', 'end_time', 'status'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}