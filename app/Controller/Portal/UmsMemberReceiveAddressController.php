<?php

declare(strict_types=1);

namespace App\Controller\Portal;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;
use App\Service\UmsMemberReceiveAddressServiceInterface;
use App\Request\UmsMemberReceivedAddressRequest;

/**
 * 会员收货地址管理
 * Class UmsMemberReceiveAddressController
 * @Controller(prefix="member/address")
 * @package App\Controller\Portal
 */
class UmsMemberReceiveAddressController extends \App\Controller\Controller
{
    /**
     * @Inject()
     * @var UmsMemberReceiveAddressServiceInterface
     */
    private $memberReceiveAddressService;

    /**
     * 添加收货地址
     * @RequestMapping(path = "add", method = "post")
     */
    public function add(UmsMemberReceivedAddressRequest $request) : ResponseInterface
    {
        $member = $this->member();
        $address = $this->transformInput($request->validated());

        $address = $this->memberReceiveAddressService->add($address, $member);

        if ($address) {
            return $this->success([]);
        }

        return $this->error('添加收货地址失败');
    }

    /**
     * 删除收货地址
     * @RequestMapping(path = "delete/{id}", method = "post")
     */
    public function delete(int $id) : ResponseInterface
    {
        $member = $this->member();
        $count = $this->memberReceiveAddressService->delete($id, $member);

        if ($count > 0) {
            return $this->success([]);
        }

        return $this->error('删除失败');
    }

    /**
     * 修改收货地址
     * @RequestMapping(path = "update/{id}", method = "post")
     */
    public function update(int $id) : ResponseInterface
    {
        $member = $this->member();
        $address = $this->transformInput($this->request->all());
        $count = $this->memberReceiveAddressService->update($id, $address, $member);

        if ($count > 0) {
            return $this->success([]);
        }

        return $this->error('修改失败');
    }

    /**
     * 显示用户所有的收货地址
     * @RequestMapping(path = "list", method = "get")
     */
    public function list() : ResponseInterface
    {
        $member = $this->member();

        $addressList = $this->memberReceiveAddressService->list($member);

        return $this->success($addressList);
    }

    /**
     * 显示用户的收货地址
     * @RequestMapping(path = "{id:\d+}", method = "get")
     */
    public function getItem(int $id)  : ResponseInterface
    {
        $member = $this->member();

        $address = $this->memberReceiveAddressService->getItem($id, $member);

        return $this->success($address);
    }
}
