<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
use Hyperf\Database\Model\SoftDeletes;

/**
 * @property int $id 
 * @property int $product_id 
 * @property int $product_sku_id 
 * @property int $member_id 
 * @property int $quantity 
 * @property float $price 
 * @property string $sp1 
 * @property string $sp2 
 * @property string $sp3 
 * @property string $product_pic 
 * @property string $product_name 
 * @property string $product_sub_title 
 * @property string $product_sku_code 
 * @property string $member_nickname 
 * @property int $product_category_id 
 * @property string $product_brand 
 * @property string $product_sn 
 * @property string $product_attr 商品销售属性:[{"key":"颜色","value":"颜色"},{"key":"容量","value":"4G"}]
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class OmsCartItem extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'oms_cart_item';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'product_sku_id', 'member_id', 'quantity', 'price', 'sp1', 'sp2', 'sp3', 'product_pic', 'product_name', 'product_sub_title', 'product_sku_code', 'member_nickname', 'product_category_id', 'product_brand', 'product_sn', 'product_attr'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'product_id' => 'integer', 'product_sku_id' => 'integer', 'member_id' => 'integer', 'quantity' => 'integer', 'price' => 'float', 'product_category_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}