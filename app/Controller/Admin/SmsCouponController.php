<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 优惠券管理
 * Class SmsCouponController
 * @Controller(prefix="coupon")
 * @package App\Controller\Admin
 */
class SmsCouponController extends AdminController
{
    /**
     * @Inject()
     * @var \App\Service\SmsCouponServiceInterface
     */
    private $couponService;

    /**
     * 添加优惠券
     * @RequestMapping(path="create", method={"post"})
     * @return ResponseInterface
     */
    public function add() : ResponseInterface
    {
        $couponParam = $this->transformInput($this->request->post());

        $coupon = $this->couponService->create($couponParam);

        if ($coupon) {
            return $this->success($coupon);
        } else {
            return $this->error();
        }
    }

    /**
     * 删除优惠券
     * @RequestMapping(path="delete/{id}", method={"post"})
     * @return ResponseInterface
     */
    public function delete(int $id)
    {
        $count = $this->couponService->delete($id);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 修改优惠券
     * @RequestMapping(path="update/{id}", method={"post"})
     * @return ResponseInterface
     */
    public function update(int $id)
    {
        $couponParam = $this->transformInput($this->request->input());
        $count = $this->couponService->update($id, $couponParam);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 根据优惠券名称和类型分页获取优惠券列表
     * @RequestMapping(path="list", method={"get"})
     * @return ResponseInterface
     */
    public function list() : ResponseInterface
    {
        $name = $this->request->input('name');
        $type = $this->request->input('type');
        $pageSize = $this->request->input('pageSize', 5);
        $pageNum = $this->request->input('pageNum', 1);

        $list = $this->couponService->list($pageSize, $pageNum, ['name'=>$name, 'type'=>$type]);

        return $this->success($list);
    }

    /**
     * 获取单个优惠券的详细信息
     * @RequestMapping(path="{id}", method={"get"})
     * @return ResponseInterface
     */
    public function getItem(int $id)
    {
        $coupon = $this->couponService->getItem($id);

        return $this->success($coupon);
    }
}
