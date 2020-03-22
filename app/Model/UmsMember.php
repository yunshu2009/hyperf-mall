<?php

declare (strict_types=1);
namespace App\Model;

use App\Library\JWTSubject;
use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $member_level_id 
 * @property string $username 
 * @property string $password 
 * @property string $nickname 
 * @property string $phone 
 * @property int $status 帐号启用状态:0->禁用；1->启用
 * @property string $icon 像
 * @property int $gender 性别：0->未知；1->男；2->女
 * @property string $birthday 生日
 * @property string $city 所做城市
 * @property string $job 职业
 * @property string $personalized_signature 个性签名
 * @property int $source_type 用户来源
 * @property int $integration 积分
 * @property int $growth 成长值
 * @property int $luckey_count 剩余抽奖次数
 * @property int $history_integration 历史积分数量
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UmsMember extends Model implements JWTSubject
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ums_member';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['member_level_id', 'username', 'password', 'nickname', 'phone', 'status', 'icon', 'gender', 'birthday', 'city', 'job', 'personalized_signature', 'source_type', 'integration', 'growth', 'luckey_count', 'history_integration'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int', 'member_level_id' => 'integer', 'status' => 'integer', 'gender' => 'integer', 'source_type' => 'integer', 'integration' => 'integer', 'growth' => 'integer', 'luckey_count' => 'integer', 'history_integration' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 查询主键
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->{$this->primaryKey};
    }
}