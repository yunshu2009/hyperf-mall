<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pms;

use App\Controller\Admin\AdminController;
use App\Request\PmsBrandRequest;
use App\Service\Admin\Pms\BrandServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PmsBrandController
 * @Controller(prefix="brand")
 *
 * @package App\Controller
 */
class BrandController extends AdminController
{
    /**
     * @Inject()
     * @var BrandServiceInterface
     */
    private $pmsBrandService;

    /**
     * 获取所有品牌列表
     * @RequestMapping(path="listAll", method={"get"})
     * @return ResponseInterface
     */
    public function getBrandList(): ResponseInterface
    {
        $list = $this->pmsBrandService->listAllBrand();

        return $this->success($list);
    }

    /**
     * 创建品牌
     * @RequestMapping(path="create", method={"post"})
     * @return ResponseInterface
     */
    public function create(PmsBrandRequest $request) : ResponseInterface
    {
        $pmsBrand = $this->transformInput($request->post());
        $pmsBrand = $this->pmsBrandService->createBrand($pmsBrand);

        if ($pmsBrand) {
            return $this->success(1);
        } else {
            return $this->error();
        }
    }

    /**
     * 更新指定id品牌信息
     * @RequestMapping(path="update/{id:\d+}", method={"post"})
     * @return ResponseInterface
     */
    public function updateBrand(int $id, PmsBrandRequest $request) : ResponseInterface
    {
        $brandParams = $this->transformInput($request->post());

        $count = $this->pmsBrandService->updateBrand($id, $brandParams);

        if ($count == 1) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 删除品牌
     * @RequestMapping(path="delete/{id:\d+}", method={"get"})
     * @return ResponseInterface
     */
    public function delete(int $id) : ResponseInterface
    {
        $count = $this->pmsBrandService->deleteBrand($id);

        if ($count == 1) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 根据品牌名称分页获取品牌列表
     * @RequestMapping(path="list", method={"get"})
     * @return ResponseInterface
     */
    public function getList() : ResponseInterface
    {
        $keyword = $this->request->input('keyword', '');
        $pageNum = $this->request->input('pageNum', 1);
        $pageSize = $this->request->input('pageSize', 5);

        // 返回格式参照pagehelper  https://github.com/pagehelper/Mybatis-PageHelper/blob/master/README_zh.md
        $brandList = $this->pmsBrandService->listBrand($keyword, $pageNum, $pageSize);

        return $this->success($brandList);
    }

    /**
     * 根据编号查询品牌信息
     * @RequestMapping(path="{id:\d+}", method={"get"})
     */
    public function getItem(int $id) : ResponseInterface
    {
        $brand = $this->pmsBrandService->getBrand($id);

        return $this->success($brand);
    }

    /**
     * 批量删除品牌
     * @RequestMapping(path="delete/batch", method={"post"})
     */
    public function deleteBatch() : ResponseInterface
    {
        $ids = $this->request->input('ids');

        if (! $ids) {
            return $this->error('请选择品牌');
        }

        $count = $this->pmsBrandService->deleteBrands($ids);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 批量更新显示状态
     * @RequestMapping(path="update/showStatus", method={"post"})
     */
    public function updateShowStatus()
    {
        $validator = $this->validationFactory->make(
            $this->request->all(),
            [
                'ids'   =>  'required|array',
            ]);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return $this->error($errorMessage);
        }
        $ids = $this->request->input('ids');
        $showStatus = (int)$this->request->input('showStatus');

        $count = $this->pmsBrandService->updateShowStatus($ids, $showStatus);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 批量更新厂家制造商状态
     * @RequestMapping(path="update/factoryStatus", method={"post"})
     */
    public function updateFactoryStatus()
    {
        $validator = $this->validationFactory->make(
            $this->request->all(),
            [
                'ids'   =>  'required|array',
            ]);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return $this->error($errorMessage);
        }

        $ids = $this->request->input('ids');
        $factoryStatus = (int)$this->request->input('factoryStatus');

        $count = $this->pmsBrandService->updateFactoryStatus($ids, $factoryStatus);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }
}
