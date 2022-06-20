<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pms;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 商品属性分类管理
 * Class PmsProductAttributeCategoryController
 *
 * @Controller(prefix="/productAttribute/category")
 * @package App\Controller\Admin
 */
class ProductAttributeCategoryController extends AdminController
{
    /**
     * @Inject()
     * @var PmsProductAttributeCategoryServiceInterface
     */
    private $productAttributeCategoryService;

    /**
     * 添加商品属性分类
     * @RequestMapping(path="create", method={"post"})
     * @return ResponseInterface
     */
    public function create() : ResponseInterface
    {
        $name = $this->request->input('name');
        $productAttributeCategory = $this->productAttributeCategoryService->create($name);

        if ($productAttributeCategory) {
            return $this->success(1);
        } else {
            return $this->error();
        }
    }

    /**
     * 修改商品属性分类
     * @RequestMapping(path = "update/{id}", method={"post"})
     * @return ResponseInterface
     */
    public function update(int $id) : ResponseInterface
    {
        $name = $this->request->input('name');
        if (! $name) {
            return $this->error('品牌名不能为空');
        }
        $count = $this->productAttributeCategoryService->update($id, $name);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 删除单个商品属性分类
     * @RequestMapping(path = "delete/{id}", method={"get"})
     * @return ResponseInterface
     */
    public function delete(int $id) : ResponseInterface
    {
        $count = $this->productAttributeCategoryService->delete($id);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 获取单个商品属性分类信息
     * @RequestMapping(path = "{id:\d+}", method={"get"})
     * @param int $id
     * @return ResponseInterface
     */
    public function getItem(int $id) : ResponseInterface
    {
        $productAttributeCategory = $this->productAttributeCategoryService->getItem($id);

        return $this->success($productAttributeCategory);
    }

    /**
     * 分页获取所有商品属性分类
     * @RequestMapping(path = "list", method={"get"})
     * @return ResponseInterface
     */
    public function getList()
    {
        $pageNum = (int)$this->request->input('pageNum', 1);
        $pageSize = (int)$this->request->input('pageSize', 5);

        $list = $this->productAttributeCategoryService->queryList([], $pageSize, $pageNum);

        return $this->success($list);
    }

    /**
     * 获取所有商品属性分类及其下属性
     * @RequestMapping(path = "list/withAttr", method={"get"})
     */
    public function getListWithAttr()
    {
        $productAttributeCategoryResultList = $this->productAttributeCategoryService->getListWithAttr();

        return $this->success($productAttributeCategoryResultList);
    }
}
