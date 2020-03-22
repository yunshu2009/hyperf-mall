<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $name 
 * @property int $growth_point 
 * @property int $default_status 是否为默认等级
 * @property int $comment_growth_point 每次评价获取的成长值
 * @property int $free_freight_point 免运费标准
 * @property int $priviledge_free_freight 是否有免邮特权
 * @property int $priviledge_sign_in 每次有签到特权
 * @property int $priviledge_comment 是否有评论奖励特权
 * @property int $priviledge_promotion 是否有专项活动特权
 * @property int $priviledge_member_price 是否有会员价格特权
 * @property int $priviledge_birthday 是否有生日特权
 * @property string $note 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UmsMemberLevel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ums_member_level';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'growth_point', 'default_status', 'comment_growth_point', 'free_freight_point', 'priviledge_free_freight', 'priviledge_sign_in', 'priviledge_comment', 'priviledge_promotion', 'priviledge_member_price', 'priviledge_birthday', 'note'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'growth_point' => 'integer', 'default_status' => 'integer', 'comment_growth_point' => 'integer', 'free_freight_point' => 'integer', 'priviledge_free_freight' => 'integer', 'priviledge_sign_in' => 'integer', 'priviledge_comment' => 'integer', 'priviledge_promotion' => 'integer', 'priviledge_member_price' => 'integer', 'priviledge_birthday' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}