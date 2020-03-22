<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Constants\ResultCode;
use App\Request\PmsProductAttributeRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Controller;
use Psr\Http\Message\ResponseInterface;
use App\Service\PmsProductAttributServiceInterface;

/**
 * 商品属性管理
 * Class PmsProductAttributeController
 *
 * @Controller(prefix="productAttribute")
 * @package App\Controller\Admin
 */
class PmsProductAttributeController extends AdminController
{
    /**
     * @Inject()
     * @var PmsProductAttributServiceInterface
     */
    private $productAttributeService;

    /**
     * 根据分类查询属性列表或参数列表
     * @RequestMapping(path = "list/{cid:\d+}", method ={"get"})
     * @return ResponseInterface
     */
    public function getList(int $cid) : ResponseInterface
    {
        $type = (int)$this->request->input('type', 0);
        $pageSize = (int)$this->request->input('pageSize', 5);
        $pageNum = (int)$this->request->input('pageNum', 1);

        $productAttributeList = $this->productAttributeService->getList($cid, $type, $pageSize, $pageNum);

        return $this->success($productAttributeList);
    }

    /**
     * 添加商品属性信息
     * @RequestMapping(path = "create", method ={"post"})
     * @return ResponseInterface
     */
    public function create(PmsProductAttributeRequest $request) : ResponseInterface
    {
        $pmsProductAttributeParam = $request->all();

        $productAttribute = $this->productAttributeService->create($pmsProductAttributeParam);
        if ($productAttribute) {
            return $this->success(1);
        } else {
            return $this->error();
        }
    }

    /**
     * 修改商品属性信息
     * @RequestMapping(path = "update/{id}", method ={"post"})
     * @return ResponseInterface
     */
    public function update(int $id, PmsProductAttributeRequest $request) : ResponseInterface
    {
        $pmsProductAttributeParam = $this->request->all();

        if (empty($pmsProductAttributeParam)) {
            return $this->error('参数不能为空', ResultCode::VALIDATE_FAILED);
        }

        $count = $this->productAttributeService->update($id, $pmsProductAttributeParam);
        if ($count) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 查询单个商品属性
     * @RequestMapping(path = "{id:\d+}", method ={"get"})
     */
    public function getItem(int $id) : ResponseInterface
    {
        $productAttribute = $this->productAttributeService->getItem($id);

        return $this->success($productAttribute);
    }

    /**
     * 批量删除商品属性
     * @RequestMapping(path = "delete", method ={"post"})
     */
    public function delete() : ResponseInterface
    {
        $ids = $this->request->input('ids');

        if (! $ids || !is_array($ids)) {
            return $this->error('请选择商品属性');
        }

        $count = $this->productAttributeService->delete($ids);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 根据商品分类的id获取商品属性及属性分类
     * @RequestMapping(path = "attrInfo/{productCategoryId:\d+}", method ={"get"})
     */
    public function getAttrInfo(int $productCategoryId) : ResponseInterface
    {
        $productAttrInfoList = $this->productAttributeService->getProductAttrInfo($productCategoryId);

        return $this->success($productAttrInfoList);
    }
}
