<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $name 
 * @property string $sub_title 
 * @property string $pic 展示图片
 * @property int $sort 
 * @property int $show_status 
 */
class CmsPrefrenceArea extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_prefrence_area';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'sub_title', 'pic', 'sort', 'show_status'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'sort' => 'integer', 'show_status' => 'integer'];

    public $timestamps = false;
}