<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $prefrence_area_id 
 * @property int $product_id 
 */
class CmsPrefrenceAreaProductRelation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_prefrence_area_product_relation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['prefrence_area_id', 'product_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'prefrence_area_id' => 'integer', 'product_id' => 'integer'];

    public $timestamps = false;
}