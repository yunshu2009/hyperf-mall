<?php
declare(strict_types=1);

namespace App\Exception;
use App\Constants\ResultCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;

class InternalException extends ServerException
{
    protected $code;
    protected $message;
    protected $httpStatus;

    public function __construct(int $code = ResultCode::SYSTEMERR, string $message = null, int $httpStatus=400, Throwable $previous = null)
    {
        if (is_null($message)) {
            $message = ResultCode::getMessage($code);
        }

        $this->code = $code;
        $this->message = $message;
        $this->httpStatus = $httpStatus;

        parent::__construct($message, $code, $previous);
    }

    public function getHttpStatusCode()
    {
        return $this->httpStatus;
    }
}
