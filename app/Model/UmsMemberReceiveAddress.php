<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $member_id 
 * @property string $name 
 * @property string $phone_number 
 * @property int $default_status 是否为默认
 * @property string $post_code 邮政编码
 * @property string $province 省份/直辖市
 * @property string $city 省份/直辖市
 * @property string $region 省份/直辖市
 * @property string $detail_address 详细地址(街道)
 */
class UmsMemberReceiveAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ums_member_receive_address';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['member_id', 'name', 'phone_number', 'default_status', 'post_code', 'province', 'city', 'region', 'detail_address'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'member_id' => 'integer', 'default_status' => 'integer'];

    public $timestamps = false;
}