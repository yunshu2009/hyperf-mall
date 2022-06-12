<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * 首页内容管理
 * Class HomeController
 * @Controller(prefix="brand")
 * @package App\Controller\Api
 */
class PmsBrandController extends \App\Controller\Controller
{
    /**
     * @Inject()
     * @var \App\Service\Api\PmsBrandService
     */
    private $brandService;

    /**
     * 分页获取推荐品牌
     * @RequestMapping(path = "recommendList", method = "get")
     */
    public function recommendList(RequestInterface $request) : ResponseInterface
    {
        $pageSize = $this->getSafePageSize($request->input('pageSize', 6));
        $pageNum = $this->getSafePageNum($request->input('pageNum', 1));

        $brandList = $this->brandService->recommendList($pageNum, $pageSize);

        return $this->success($brandList);
    }
}
