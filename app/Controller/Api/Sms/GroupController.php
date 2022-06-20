<?php

namespace App\Controller\Api\Sms;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * 团购管理
 * Class SmsGroupController
 * @Controller(prefix="api/group")
 * @package App\Controller\Api
 */
class GroupController extends \App\Controller\Controller
{

    /**
     * @Inject()
     * @var \App\Service\Api\Sms\GroupServiceInterface
     */
    private $groupService;

    /**
     * 根据首页团购列表
     * @RequestMapping(path = "list", method = {"get"})
     */
    public function index()
    {
        $rules = [
            'pageSize'      =>  'required|integer|min:1',
            'pageNum'   =>  'required|integer|min:1',
        ];
        if ($error = $this->validateInput($rules)) {
            return $error;
        }

        $res = $this->groupService->getList($this->validated);

        return $this->success($res);
    }
}
