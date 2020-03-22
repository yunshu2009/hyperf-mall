<?php

declare(strict_types=1);

namespace App\Controller\Portal;

use App\Constants\ResultCode;
use App\Request\UserLoginRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

/**
 * 会员登录注册管理
 * Class UmsMemberController
 * @Controller(prefix="sso")
 * @package App\Controller\Portal
 */
class UmsMemberController extends \App\Controller\Controller
{
    private $tokenHeader = 'Authorization';
    private $tokenHead = 'Bearer';

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * @Inject()
     * @var \App\Service\UmsMemberServiceInterface
     */
    private $memberService;

    /**
     * 会员登录
     * @RequestMapping(path = "login", method = "post")
     */
    public function login(UserLoginRequest $request) : ResponseInterface
    {
        $validated = $request->validated();
        $token = $this->memberService->login($validated['username'], trim($validated['password']));

        $tokenMap = [
            'tokenHead' =>  $this->tokenHead,
            'token'     =>  $token,
            'expireIn'  =>  config('jwt.ttl') * 60,
        ];
        return $this->success($tokenMap);
    }

    /**
     * 刷新token
     * @RequestMapping(path = "refreshToken", method = "get")
     */
    public function refreshToken() : ResponseInterface
    {
        $token = $this->request->header($this->tokenHeader);
        if (! $token) {
            return $this->error(ResultCode::VALIDATE_FAILED, "参数错误");
        }

        $refreshToken = $this->memberService->refreshToken($token);

        if (empty($refreshToken)) {
            return $this->error(ResultCode::FAILED, "token已经过期！");
        }

        $tokenMap = [
            'tokenHead' =>  $this->tokenHead,
            'token'     =>  $refreshToken,
            'expireIn'  =>  config('jwt.ttl') * 60,
        ];

        return $this->success($tokenMap);
    }

    /**
     * 会员注册
     * @RequestMapping(path = "register", method = "post")
     */
    public function register() : ResponseInterface
    {
        $validator = $this->validationFactory->make(
            $this->request->post(),
            [
                'username' => 'required',
                'password' => 'required',
                'telephone' => 'required',
                'authCode' => 'required',
            ],
            [
                'foo.required' => '用户名不能为空',
                'password.required' => '用户名不能为空',
                'telephone.required' => '电话不能为空',
                'authCode.required' => '验证码不能为空',
            ]
        );

        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $input = $validator->validated();

        $member = $this->memberService->register($input['username'], $input['password'], $input['telephone'], $input['authCode']);

        return $this->success($member);
    }

    /**
     * 获取验证码
     * @RequestMapping(path = "getAuthCode", method = "get")
     */
    public function getAuthCode() : ResponseInterface
    {
        $telephone = $this->request->input('telephone');

        if (! $telephone) {
            return $this->error('手机号不能为空');
        }

        $authCode = $this->memberService->generateAuthCode($telephone);

        return $this->success($authCode);
    }

    /**
     * 修改密码
     * @RequestMapping(path = "updatePassword", method = "post")
     */
    public function updatePassword() : ResponseInterface
    {
        $validator = $this->validationFactory->make(
            $this->request->post(),
            [
                'password' => 'required',
                'telephone' => 'required',
                'authCode' => 'required',
            ],
            [
                'password.required' => '用户名不能为空',
                'telephone.required' => '电话不能为空',
                'authCode.required' => '验证码不能为空',
            ]
        );

        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $input = $validator->validated();

        $this->memberService->updatePassword($input['telephone'], $input['password'], $input['authCode']);

        return $this->success([]);
    }
}
