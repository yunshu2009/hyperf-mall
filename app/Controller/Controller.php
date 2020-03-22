<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Constants\ResultCode;
use App\Exception\BusinessException;
use App\Library\JWT;
use App\Model\UmsMember;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\Str;
use Psr\Container\ContainerInterface;

abstract class Controller
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    public function success($data=[], $message='操作成功', $code=200)
    {
        return $this->reponse($data, $message, $code);
    }

    public function error($message='操作失败', $code=ResultCode::FAILED, $statusCode=200)
    {
        return $this->reponse(null, $message, $code, $statusCode);
    }

    public function reponse($data, $message, $code, $statusCode=200)
    {
        $data = json_encode([
            'code'  =>  $code,
            'message'   =>  $message,
            'data'  =>  $data,
        ], 320);

        return $this->response->withStatus($statusCode)->withHeader('Content-Type', 'application/json')->withBody(new SwooleStream($data));
    }

    /**
     * 将输入转为蛇型变量命名风格
     * @param array $arr
     *
     * @return array
     */
    protected function transformInput(array $arr) : array
    {
        $newArr = [];
        foreach ($arr as  $k=>$v){
            if (is_string($k)) {
                $k = Str::snake($k);
            }
            if(is_array($v)){
                $v = $this->transformInput($v);
            }

            $newArr[$k] = $v;
        }

        return $newArr;
    }

    protected function member()
    {
        $token = $this->request->header('Authorization');
        if (! $token) {
            throw new BusinessException(ResultCode::VALIDATE_FAILED, "需要认证");
        }

        $check = (new JWT())->check(UmsMember::class, $token);

        if (! $check) {
            throw new BusinessException(ResultCode::VALIDATE_FAILED, "认证错误");
        }

        list($member, $payload) = $check;

        return $member;
    }
}
