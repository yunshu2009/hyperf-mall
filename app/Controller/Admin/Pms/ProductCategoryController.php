<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pms;

use App\Request\PmsProductCategoryRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;


/**
 * 商品分类模块
 * Class PmsProductCategoryController
 *
 * @Controller(prefix="productCategory")
 * @package App\Controller\Admin
 */
class ProductCategoryController extends AdminController
{
    /**
     * @Inject()
     * @var PmsProductCategoryServiceInterface
     */
    private $productCategoryService;

    /**
     * 添加产品分类
     * @RequestMapping(path = "create", method ={"post"})
     * @return ResponseInterface
     */
    public function create(PmsProductCategoryRequest $request) : ResponseInterface
    {
        $productCategoryParam = $this->request->all();
        $productCategory = $this->productCategoryService->create($productCategoryParam);
        if ($productCategory) {
            return $this->success(1);
        } else {
            return $this->error();
        }
    }

    /**
     * 修改商品分类
     * @RequestMapping(path = "update/{id:\d+}", method ={"post"})
     * @return ResponseInterface
     */
    public function update(int $id, PmsProductCategoryRequest $request) : ResponseInterface
    {
        $productCategoryParam = $request->all();

        $count = $this->productCategoryService->update($id, $productCategoryParam);
        if ($count) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 分页查询商品分类
     * @RequestMapping(path = "list/{parentId:\d+}", method ={"get"})
     * @return ResponseInterface
     */
    public function getList(int $parentId) : ResponseInterface
    {
        $pageSize = (int)$this->request->input('pageSize', 5);
        $pageNum = (int)$this->request->input('pageNum', 1);

        $productCategoryList = $this->productCategoryService->getList($parentId, $pageSize, $pageNum);

        return $this->success($productCategoryList);
    }

    /**
     * 根据id获取商品分类
     * @RequestMapping(path = "{id:\d+}", method ={"get"})
     * @return ResponseInterface
     */
    public function getItem(int $id) : ResponseInterface
    {
        $productCategory = $this->productCategoryService->getItem($id);

        return $this->success($productCategory);
    }

    /**
     * 删除商品分类
     * @RequestMapping(value = "delete/{id}", method ={"get"})
     * @return ResponseInterface
     */
    public function delete(int $id) : ResponseInterface
    {
        $count = $this->productCategoryService->delete($id);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 修改导航栏显示状态
     * @RequestMapping(value = "update/navStatus", method ={"post"})
     * @return ResponseInterface
     */
    public function updateNavStatus() : ResponseInterface
    {
        $ids = $this->request->input('ids');
        $navStatus = (int)$this->request->input('navStatus');

        if (!$ids || !in_array($navStatus, [0,1]) || !is_array($ids)) {
            return $this->error('参数错误');
        }

        $count = $this->productCategoryService->updateNavStatus($ids, $navStatus);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 修改显示状态
     * @RequestMapping(value = "update/showStatus", method ={"post"})
     * @return ResponseInterface
     */
    public function updateShowStatus() : ResponseInterface
    {
        $ids = $this->request->input('ids');
        $showStatus = (int)$this->request->input('showStatus');

        if (!$ids || !in_array($showStatus, [0,1]) || !is_array($ids)) {
            return $this->error('参数错误');
        }

        $count = $this->productCategoryService->updateShowStatus($ids, $showStatus);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 查询所有一级分类及子分类
     * @RequestMapping(value = "list/withChildren", method = {"get"})
     * @return ResponseInterface
     */
    public function listWithChildren() : ResponseInterface
    {
        $productCategoryWithChildrenItemList = $this->productCategoryService->listWithChildren();

        return $this->success($productCategoryWithChildrenItemList);
    }
}
