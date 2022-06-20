<?php
declare(strict_types=1);

namespace App\Service\Api\Ums;

use App\Model\UmsMemberLevel;
use App\Service\Service;
use Hyperf\Di\Annotation\Inject;
use App\Constants\ResultCode;
use App\Exception\BusinessException;
use App\Library\JWT;
use App\Model\UmsMember;
use Hyperf\Utils\Str;

class MemberService extends Service implements MemberServiceInterface
{
    /**
     * @Inject()
     * @var JWT
     */
    private $jwt;

    public function login(string $username, string $password) : string
    {
        $user =$this->loadUserByUsername($username);

        if (! password_verify($password, $user->password)) {
            throw new BusinessException(ResultCode::FAILED, "密码不正确");
        }

        return $this->jwt->fromUser($user);
    }

    public function refreshToken(string $token) : string
    {
       $check = $this->jwt->check(UmsMember::class, $token);

       if (! $check ) {
           throw new BusinessException(ResultCode::FAILED, "token无效或已过期");
       }

        list($user, $payload) = $check;

        if (time() - $payload->iat < 30*60) {   // 30分钟内签发的
           return $token;
        }

        // 重新签发
        return $this->jwt->fromUser($user);
    }

    public function register(string $username, string $password, string $telephone, string $authCode)
    {
        if(! $this->verifyAuthCode($authCode, $telephone)) {
            throw new BusinessException(ResultCode::FAILED, "验证码错误");
        }

        // 查询是否已有该用户
        $count = UmsMember::where('username', $username)->orWhere('phone', $telephone)
                ->count();
        if ($count > 0) {
            throw new BusinessException(ResultCode::FAILED, "该用户已经存在");
        }

        // 没有该用户进行添加操作
        $userMember['username'] = $username;
        $userMember['phone'] = $telephone;
        $userMember['password'] = password_hash($telephone, PASSWORD_BCRYPT);
        $userMember['status'] = 1;
        // 获取默认会员等级并设置
        $member_level = UmsMemberLevel::where('default_status', 1)->first();
        if ($member_level) {
            $userMember['member_level_id'] = $member_level['id'];
        }
        UmsMember::create($userMember);

        unset($userMember['password']);

        return $userMember;
    }

    private function verifyAuthCode($authCode, $telephone)
    {
        if (empty($authCode)) {
            return false;
        }

        $realAuthCode = $this->getRedis()->get(config('redis_keys.register_auth_code.prefix').$telephone);

        return $realAuthCode == $authCode;
    }

    private function loadUserByUsername(string $username)
    {
        $member = $this->getByUsername($username);
        if(! $member){
            throw new BusinessException(ResultCode::FAILED, "用户不存在");
        }

        return $member;
    }

    private function getByUsername(string $username)
    {
        return UmsMember::where([
            'username'  =>  $username,
            'status'     =>  1,
        ])->first();
    }

    public function generateAuthCode(string $telephone) : string
    {
        $authCode = Str::random(6);

        // 验证码绑定手机号并存储到redis
        $key = config('redis_keys.register_auth_code.prefix').$telephone;
        $expire = config('redis_keys.register_auth_code.expire');

//        if ($this->getRedis()->ttl($key) > 0) {
//            throw new BusinessException(ResultCode::FAILED, '发送验证码过于频繁，请稍后再试');
//        }
        // todo:发送验证码
        $this->getRedis()->set($key, $authCode, $expire);

        return $authCode;
    }

    public function updatePassword(string $telephone, string $password, string $authCode) : bool
    {
        $member = UmsMember::where('phone', $telephone)->first();
        if (! $member) {
            throw new BusinessException(ResultCode::FAILED, '该账号不存在');
        }

        if (! $this->verifyAuthCode($authCode, $telephone)) {
            throw new BusinessException(ResultCode::FAILED, '验证码错误');
        }

        $member->password = password_hash($password, PASSWORD_BCRYPT);
        $member->save();

        return true;
    }
}
