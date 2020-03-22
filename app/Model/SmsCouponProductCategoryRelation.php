<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $coupon_id 
 * @property int $product_category_id 
 * @property string $product_category_name 商品分类
 * @property string $parent_category_name 父分类名称
 */
class SmsCouponProductCategoryRelation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_coupon_product_category_relation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['coupon_id', 'product_category_id', 'product_category_name', 'parent_category_name'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'coupon_id' => 'integer', 'product_category_id' => 'integer'];
}