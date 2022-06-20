<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Controller;
use App\Service\Api\MemberCollectionServiceInterface;

/**
 * 会员登录注册管理
 * Class MemberCollectionController
 * @Controller(prefix="api/member/collection")
 * @package App\Controller\Portal
 */
class MemberCollectionController
{
    /**
     * @Inject()
     * @var MemberCollectionServiceInterface
     */
    private $memberCollectionService;
    /**
     * 添加商品收藏
     * @RequestMapping(path = "addProduct", method = "post")
     */
    public function addProduct()
    {
//        $count = $this->memberCollectionService->addProduct($productCollection);
//        if ($count > 0) {
//            return $this->success($count);
//        } else {
//            return $this->error();
//        }
    }
}
