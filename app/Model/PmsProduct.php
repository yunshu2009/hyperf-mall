<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 */
class PmsProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pms_product';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'product_category_id',
        'feight_template_id',
        'product_attribute_category_id',
        'name',
        'pic',
        'product_sn',
        'delete_status',
        'publish_status',
        'new_status',
        'recommand_status',
        'verify_status',
        'sort',
        'sale',
        'price',
        'promotion_price',
        'gift_growth',
        'gift_point',
        'use_point_limit',
        'sub_title',
        'description',
        'original_price',
        'stock',
        'low_stock',
        'unit',
        'weight',
        'preview_status',
        'service_ids',
        'keywords',
        'note',
        'album_pics',
        'detail_title',
        'detail_desc',
        'detail_html',
        'detail_mobile_html',
        'promotion_start_time',
        'promotion_end_time',
        'promotion_per_limit',
        'promotion_type',
        'brand_name',
        'product_category_name',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}