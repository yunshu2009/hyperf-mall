<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Psr\Http\Message\ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use App\Service\SmsCouponServiceInterface;

/**
 * 优惠券领取记录管理
 * Class SmsCouponController
 * @Controller(prefix="couponHistory")
 * @package App\Controller\Admin
 */
class SmsCouponHistoryController extends AdminController
{
    /**
     * @Inject()
     * @var SmsCouponServiceInterface
     */
    private $couponHistoryService;

    /**
     * 根据优惠券id，使用状态，订单编号分页获取领取记录
     * @RequestMapping(path="list", method={"get"})
     * @return ResponseInterface
     */
    public function list() : ResponseInterface
    {
        $couponId = $this->request->post('couponId');
        $useStatus = $this->request->post('useStatus');
        $orderSn = $this->request->post('orderSn');
        $pageSize = $this->request->post('pageSize');
        $pageNum = $this->request->post('pageNum');

        $couponHistoryList = $this->couponHistoryService->list($pageSize, $pageNum, $couponId, $useStatus, $orderSn);
        return $this->success($couponHistoryList);
    }
}
