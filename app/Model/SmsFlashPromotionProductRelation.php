<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $flash_promotion_id 
 * @property int $flash_promotion_session_id 限时购场次
 * @property int $product_id 
 * @property float $flash_promotion_price 限时购价格
 * @property int $flash_promotion_count 限时购数量
 * @property int $flash_promotion_limit 每人限购数量
 * @property int $sort 排序
 */
class SmsFlashPromotionProductRelation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_flash_promotion_product_relation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['flash_promotion_id', 'flash_promotion_session_id', 'product_id', 'flash_promotion_price', 'flash_promotion_count', 'flash_promotion_limit', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'flash_promotion_id' => 'integer', 'flash_promotion_session_id' => 'integer', 'product_id' => 'integer', 'flash_promotion_price' => 'float', 'flash_promotion_count' => 'integer', 'flash_promotion_limit' => 'integer', 'sort' => 'integer'];

    public $timestamps = false;
}