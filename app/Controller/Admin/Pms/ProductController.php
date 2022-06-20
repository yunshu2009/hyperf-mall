<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pms;

use App\Request\PmsProductRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 商品管理
 * Class PmsProductController
 * @Controller(prefix="product")
 * @package App\Controller\Admin
 */
class ProductController extends AdminController
{

    /**
     * @Inject()
     * @var PmsProductServiceInterface
     */
    private $productService;

    /**
     * 创建商品
     * @RequestMapping(path = "create", method = {"post"})
     * @return ResponseInterface
     */
    public function create(PmsProductRequest $request) : ResponseInterface
    {
        $productParam = $this->transformInput($request->post());

        $product = $this->productService->create($productParam);

        if ($product) {
            return $this->success(1);
        } else {
            return $this->error();
        }
    }

    /**
     * 根据商品id获取商品编辑信息
     * @RequestMapping(path = "updateInfo/{id}", method = {"post"})
     */
    public function getUpdateInfo(int $id) : ResponseInterface
    {
        $productResult = $this->productService->getUpdateInfo($id);
        return $this->success($productResult);
    }

    /**
     * 更新商品
     * @RequestMapping(path = "update/{:id}", method = {"post"})
     */
    public function update(int $id) : ResponseInterface
    {
        $productParam = $this->request->post();
        $count = $this->productService->update($id, $productParam);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 查询商品
     * @RequestMapping(path = "simpleList", method = {"get"})
     */
    public function getList(int $id) : ResponseInterface
    {
        $productQueryParam = $this->transformInput($this->request->post());
        $pageNum = $this->request->input('pageNum', 1);
        $pageSize = $this->request->input('pageSize', 5);

        $productList = $this->productService->list($productQueryParam, $pageNum, $pageSize);

        $productParam = $this->request->post();
        $count = $this->productService->update($id, $productParam);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 根据商品名称或货号模糊查询
     * @RequestMapping(path = "list", method = {"get"})
     */
    public function getSimpleList() : ResponseInterface
    {
        $keyword = $this->request->input('keyword');

        $productList = $this->productService->simpleList($keyword);

        return $this->success($productList);
    }

    /**
     * 批量修改审核状态
     * @RequestMapping(path = "update/verifyStatus", method = {"post"})
     */
    public function updateVerifyStatus() : ResponseInterface
    {
        $ids = $this->request->input('ids');
        $verifyStatus = $this->request->input('verifyStatus');

        $count = $this->productService->updateVerifyStatus($ids, $verifyStatus);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 批量上下架
     * @RequestMapping(path = "update/publishStatus", method = {"post"})
     * @return ResponseInterface
     */
    public function updatePublishStatus() : ResponseInterface
    {
        $ids = (array)$this->request->input('ids');
        $publishStatus = (int)$this->request->input('publishStatus');

        $count = $this->productService->updatePublishStatus($ids, $publishStatus);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 批量推荐商品
     * @RequestMapping(path = "update/recommendStatus", method = {"post"})
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updateRecommendStatus() : ResponseInterface
    {
        $ids = (array)$this->request->input('ids');
        $recommendStatus = (int)$this->request->input('recommendStatus');

        $count = $this->productService->updateRecommendStatus($ids, $recommendStatus);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 批量设为新品
     * @RequestMapping(path = "update/newStatus", method = {"post"})
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updateNewStatus() : ResponseInterface
    {
        $ids = (array)$this->request->input('ids');
        $newStatus = (int)$this->request->input('newStatus');

        $count = $this->productService->updateNewStatus($ids, $newStatus);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 批量修改删除状态
     * @RequestMapping(path = "update/deleteStatus", method = {"post"})
     */
    public function updateDeleteStatus()
    {
        $ids = (array)$this->request->input('ids');
        $deleteStatus = (int)$this->request->input('deleteStatus');

        $count = $this->productService->updateDeleteStatus($ids, $deleteStatus);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }
}
