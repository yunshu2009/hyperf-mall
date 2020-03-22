<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $product_id 
 * @property int $member_level_id 
 * @property float $member_price 
 * @property string $member_level_name 
 */
class PmsMemberPrice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pms_member_price';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'member_level_id', 'member_price', 'member_level_name'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'product_id' => 'integer', 'member_level_id' => 'integer', 'member_price' => 'float'];

    public $timestamps = false;
}