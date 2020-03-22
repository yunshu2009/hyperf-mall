<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $brand_id 
 * @property string $brand_name 
 * @property int $recommend_status 
 * @property int $sort 
 */
class SmsHomeBrand extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_home_brand';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['brand_id', 'brand_name', 'recommend_status', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'brand_id' => 'integer', 'recommend_status' => 'integer', 'sort' => 'integer'];

    public $timestamps = false;
}