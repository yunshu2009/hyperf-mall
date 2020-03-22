<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $product_id 
 * @property int $count 满足的商品数量
 * @property float $discount 折扣
 * @property float $price 折后价格
 */
class PmsProductLadder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pms_product_ladder';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'count', 'discount', 'price'];

    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'product_id' => 'integer', 'count' => 'integer', 'discount' => 'float', 'price' => 'float'];
}