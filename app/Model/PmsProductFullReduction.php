<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $product_id 
 * @property float $full_price 
 * @property float $reduce_price 
 */
class PmsProductFullReduction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pms_product_full_reduction';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'full_price', 'reduce_price'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'product_id' => 'integer', 'full_price' => 'float', 'reduce_price' => 'float'];
}