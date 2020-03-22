<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $subject_id 
 * @property string $subject_name 
 * @property int $recommend_status 
 * @property int $sort 
 */
class SmsHomeRecommendSubject extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_home_recommend_subject';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject_id', 'subject_name', 'recommend_status', 'sort'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'subject_id' => 'integer', 'recommend_status' => 'integer', 'sort' => 'integer'];

    public $timestamps = false;
}