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

namespace App\Exception\Handler;

use App\Constants\ResultCode;
use App\Exception\BusinessException;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory->get('default');
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof BusinessException) { // 业务异常
            $httpStatus = $throwable->getHttpStatusCode();

            $data = json_encode([
                'code'      =>    $throwable->getCode(),
                'message'   =>    $throwable->getMessage(),
                'status'    =>    $httpStatus,
            ], JSON_UNESCAPED_UNICODE);
        } elseif ($throwable instanceof ValidationException) { // 框架业务逻辑异常
            $httpStatus = 400;
            $data = json_encode([
                'status' => ResultCode::VALIDATE_FAILED,
                'message' => current((array)collect($throwable->errors())->first()),
            ], JSON_UNESCAPED_UNICODE);
        } elseif ($throwable instanceof ModelNotFoundException) {
            $httpStatus = 404;
            $data = json_encode([
                'code' => ResultCode::FAILED,
                'message' => '数据不存在',
                'status'    =>    $httpStatus,
            ], JSON_UNESCAPED_UNICODE);
        } else { // 系统异常
            $httpStatus = 500;
            $data = json_encode([
                'code'      => ResultCode::SYSTEMERR,
                'message'   => '系统异常',
                'status'    =>  $httpStatus,
            ], JSON_UNESCAPED_UNICODE);

            $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
            $this->logger->error($throwable->getTraceAsString());
        }

        // 阻止异常冒泡
        $this->stopPropagation();

        return $response->withStatus($httpStatus)->withHeader('Content-Type', 'application/json')->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
