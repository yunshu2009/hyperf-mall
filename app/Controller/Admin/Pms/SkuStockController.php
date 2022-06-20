<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pms;

use App\Controller\Admin\AdminController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 商品管理
 * Class PmsSkuStockController
 * @Controller(prefix="sku")
 * @package App\Controller\Admin
 */
class SkuStockController extends AdminController
{
    /**
     * @Inject()
     * @var \App\Service\Admin\Pms\SkuStockServiceInterface
     */
    private $skuStockService;

    /**
     * 根据商品编号及编号模糊搜索sku库存
     * @RequestMapping(path = "{pid}", method = {"get"})
     * @return ResponseInterface
     */
    public function getList(int $pid) : ResponseInterface
    {
        $keyword = $this->request->input('keyword');

        $skuStockList = $this->skuStockService->getList($pid, $keyword);

        return $this->success($skuStockList);
    }

    /**
     * 批量更新库存信息
     * @RequestMapping(path = "update/{pid}", method = {"post"})
     * @return ResponseInterface
     */
    public function update(int $pid) : ResponseInterface
    {
        $skuStockList = $this->transformInput($this->request->post());

        $count = $this->skuStockService->update($pid, $skuStockList);

        if ($count > 0) {
            return $this->success($skuStockList);
        } else {
            return $this->error();
        }
    }
}
