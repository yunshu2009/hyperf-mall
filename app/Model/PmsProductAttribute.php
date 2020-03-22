<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 */
class PmsProductAttribute extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pms_product_attribute';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = false;

    protected $fillable = [
        'product_attribute_category_id',
        'name',
        'select_type',
        'input_type',
        'input_list',
        'sort',
        'filter_type',
        'search_type',
        'related_status',
        'hand_add_status',
        'type'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    public function productAttributeCategory()
    {
        return $this->belongsTo(PmsProductAttribute::class, 'id', 'product_attribute_category_id');
    }
}