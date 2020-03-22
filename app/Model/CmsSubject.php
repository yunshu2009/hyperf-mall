<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $category_id 
 * @property string $title 
 * @property string $pic 专题主图
 * @property int $product_count 关联产品数量
 * @property int $recommend_status 显示状态：0->不显示；1->显示
 * @property int $collect_count 收藏数量
 * @property int $comment_count 
 * @property int $read_count 阅读数量
 * @property string $album_pics 画册图片用逗号分割
 * @property string $description 描述
 * @property int $show_status 显示状态：0->不显示；1->显示
 * @property string $content 
 * @property int $forward_count 转发数
 * @property string $category_name 专题分类名称
 * @property \Carbon\Carbon $created_at 
 */
class CmsSubject extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_subject';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'category_id', 'title', 'pic', 'product_count', 'recommend_status', 'collect_count', 'comment_count', 'read_count', 'album_pics', 'description', 'show_status', 'content', 'forward_count', 'category_name', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'category_id' => 'integer', 'product_count' => 'integer', 'recommend_status' => 'integer', 'collect_count' => 'integer', 'comment_count' => 'integer', 'read_count' => 'integer', 'show_status' => 'integer', 'forward_count' => 'integer', 'created_at' => 'datetime'];
}