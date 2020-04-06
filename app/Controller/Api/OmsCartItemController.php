<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Request\Portal\OmsCartItemRequest;
use App\Request\Portal\OmsCartItemUpdateQuantityRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;
use App\Service\OmsCartItemServiceInterface;
/**
 * 购物车管理
 * Class CartItemController
 * @Controller(prefix="api/cart")
 * @package App\Controller\Portal
 */
class OmsCartItemController extends \App\Controller\Controller
{
    /**
     * @Inject()
     * @var OmsCartItemServiceInterface
     */
    private $cartItemService;

    /**
     * 添加商品到购物车
     * @RequestMapping(path = "add", method = "post")
     */
    public function add(OmsCartItemRequest $request) : ResponseInterface
    {
        $member = $this->member();
        $cartItem = $this->transformInput($request->validated());

        $cartItem = $this->cartItemService->add($cartItem, $member);

        if ($cartItem) {
            return $this->success(1);
        }

        return $this->error();
    }

    /**
     * 获取某个会员的购物车列表
     * @RequestMapping(path = "list", method = "get")
     */
    public function list()
    {
        $member = $this->member();
        $memberId = $member['id'];

        $cartItemList = $this->cartItemService->list($memberId);

        return $this->success($cartItemList);
    }

    /**
     * 获取某个会员的购物车列表,包括促销信息
     * @RequestMapping(path = "list/promotion", method = "get")
     */
    public function listPromotion()
    {
        $member = $this->member();
        $memberId = $member['id'];
        $cartPromotionItemList = $this->cartItemService->listPromotion($memberId);

        return $cartPromotionItemList;
    }

    /**
     * 修改购物车中某个商品的数量
     * @RequestMapping(path = "update/quantity", method = "post")
     */
    public function updateQuantity(OmsCartItemUpdateQuantityRequest $request)
    {
        $member = $this->member();
        $memberId = $member['id'];

        $id = $request->input('id');
        $quantity = $request->input('quantity');

        $count = $this->cartItemService->updateQuantity($memberId, $id, $quantity);

        if ($count) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * 删除购物车中的某个商品
     * @RequestMapping(path = "delete", method = "post")
     */
    public function delete()
    {
        $ids = $this->request->input('ids');
        if (!$ids || !is_array($ids)) {
            return $this->error('参数错误');
        }

        $member = $this->member();
        $count = $this->cartItemService->delete($member['id'], $ids);

        if ($count) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * 清空购物车
     * @RequestMapping(path = "clear", method = "post")
     */
    public function clear()
    {
        $member = $this->member();
        $count = $this->cartItemService->clear($member['id']);

        if ($count) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * 修改购物车中商品的规格
     * @RequestMapping(path = "update/attr", method = "post")
     */
    public function updateAttr()
    {
        $cartItem = $this->request->input('cartItem');
        if ( ! $cartItem || ! is_array($cartItem) || ! isset($cartItem['id'])) {
            return $this->error('参数错误');
        }

        $member = $this->member();
        $count  = $this->cartItemService->updateAttr($member['id'], $cartItem);
        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 获取购物车中某个商品的规格,用于重选规格
     * @RequestMapping(path = "product/{productId}", method = "get")
     */
    public function getCartProduct($productId)
    {
        $cartProduct = $this->cartItemService->getCartProduct($productId);

        return $this->success($cartProduct);
    }
}
