<?php

declare (strict_types=1);
namespace App\Model;

/**
 */
class PmsProductAttributeCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pms_product_attribute_category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'attribute_count',
        'param_count',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public $timestamps = false;

    public function productAttributeList()
    {
        return $this->hasMany(PmsProductAttribute::class, 'product_attribute_category_id', 'id');
    }
}