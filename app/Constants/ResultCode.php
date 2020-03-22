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
namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ResultCode extends AbstractConstants
{
    /**
     * @Message("操作成功")
     */
    const SUCCESS = 200;
    /**
     * @Message("操作失败")
     */
    const FAILED = 400;
    /**
     * @Message("参数检验失败")
     */
    const VALIDATE_FAILED = 404;
    /**
     * @Message("暂未登录或token已经过期")
     */
    const UNAUTHORIZED = 401;
    /**
     * @Message("没有相关权限")
     */
    const FORBIDDEN = 403;
    /**
     * @Message("系统异常")
     */
    const SYSTEMERR = 999;
}