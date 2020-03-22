<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $coupon_id 
 * @property int $product_id 
 * @property string $product_name 商品名称
 * @property string $product_sn 商品编码
 */
class SmsCouponProductRelation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_coupon_product_relation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['coupon_id', 'product_id', 'product_name', 'product_sn'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'coupon_id' => 'integer', 'product_id' => 'integer'];
}