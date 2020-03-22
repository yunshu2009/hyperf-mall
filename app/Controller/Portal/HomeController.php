<?php

declare(strict_types=1);

namespace App\Controller\Portal;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;
use App\Service\HomeServiceInterface;

/**
 * 首页内容管理
 * Class HomeController
 * @Controller(prefix="home")
 * @package App\Controller\Portal
 */
class HomeController extends \App\Controller\Controller
{
    /**
     * @Inject()
     * @var HomeServiceInterface
     */
    private $homeService;

    /**
     * 首页内容页信息展示
     * @RequestMapping(path="content", method={"get"})
     * @return ResponseInterface
     */
    public function getContent() : ResponseInterface
    {
        $content = $this->homeService->getContent();

        return $this->success($content);
    }

    /**
     * 分页获取推荐商品
     * @RequestMapping(path = "recommendProductList", method = "get")
     */
    public function recommendProductList()
    {
        $pageSize = (int)$this->request->input('pageSize', 4);
        $pageNum = (int)$this->request->input('pageNum', 1);

        $productList = $this->homeService->recommendProductList($pageSize, $pageNum);

        return $this->success($productList);
    }

    /**
     * 获取首页商品分类
     * @RequestMapping(path = "productCateList/{parentId}", method = "get")
     */
    public function getProductCateList(int $parentId)
    {
        $productCategoryList = $this->homeService->getProductCateList($parentId);

        return $this->success($productCategoryList);
    }

    /**
     * 根据分类获取专题
     * @RequestMapping(path = "subjectList", method = {"get"})
     */
    public function getSubjectList()
    {
        $cateId = (int)$this->request->input('cateId', 0);
        $pageSize = (int)$this->request->input('pageSize', 4);
        $pageNum = (int)$this->request->input('pageNum', 1);

        $subjectList = $this->homeService->getSubjectList($cateId, $pageSize, $pageNum);

        return $this->success($subjectList);
    }
}
