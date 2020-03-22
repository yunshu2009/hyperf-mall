<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $first_letter
 * @property int $sort
 * @property int $factory_status
 * @property int $show_status
 * @property int $product_count
 * @property int $product_comment_count
 * @property string $logo
 * @property string $big_pic
 * @property string $brand_story
 */
class PmsBrand extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pms_brand';

    protected $connection = 'default';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_letter',
        'sort',
        'integer',
        'factory_status',
        'show_status',
        'product_count',
        'product_comment_count',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'sort' => 'integer', 'factory_status' => 'integer', 'show_status' => 'integer', 'product_count' => 'integer', 'product_comment_count' => 'integer'];
}