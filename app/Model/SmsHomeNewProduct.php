<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $product_id 
 * @property string $product_name 
 * @property int $recommend_status 
 * @property int $sort 
 */
class SmsHomeNewProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_home_new_product';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'product_name', 'recommend_status', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'product_id' => 'integer', 'recommend_status' => 'integer', 'sort' => 'integer'];
}