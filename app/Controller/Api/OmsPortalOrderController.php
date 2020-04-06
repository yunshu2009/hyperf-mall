<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\Di\Annotation\Inject;
use App\Service\OmsPortalOrderServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * 订单管理
 * Class HomeController
 * @Controller(prefix="api/order")
 * @package App\Controller\Portal
 */
class OmsPortalOrderController extends \App\Controller\Controller
{
    /**
     * @Inject()
     * @var OmsPortalOrderServiceInterface
     */
    private $portalOrderService;

    /**
     * 根据购物车信息生成确认单信息
     * @RequestMapping(path = "generateConfirmOrder", method = "post")
     */
    public function generateConfirmOrder() : ResponseInterface
    {
        $member = $this->member();

        $res = $this->portalOrderService->generateConfirmOrder($member);

        return $this->success($res);
    }
}
