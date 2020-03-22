<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $product_id 
 * @property string $sku_code sku编码
 * @property float $price 
 * @property int $stock 库存
 * @property int $low_stock 预警库存
 * @property string $sp1 
 * @property string $sp2 
 * @property string $sp3 
 * @property string $props 销售属性
 * @property string $pic 展示图片
 * @property int $sale 
 * @property int $promotion_price 单品促销价格
 * @property int $lock_stock 锁定库存
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class PmsSkuStock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pms_sku_stock';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'product_id', 'sku_code', 'price', 'stock', 'low_stock', 'sp1', 'sp2', 'sp3', 'props', 'pic', 'sale', 'promotion_price', 'lock_stock'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'product_id' => 'integer', 'price' => 'float', 'stock' => 'integer', 'low_stock' => 'integer', 'sale' => 'integer', 'promotion_price' => 'integer', 'lock_stock' => 'integer'];
}