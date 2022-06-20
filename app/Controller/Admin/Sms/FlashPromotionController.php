<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sms;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use App\Service\FlashPromotionServiceInterface;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\str;

/**
 * 限时购活动管理
 * Class FlashPromotionController
 * @Controller(prefix="flash")
 * @package App\Controller\Admin
 */
class FlashPromotionController extends AdminController
{
    /**
     * @Inject()
     * @var FlashPromotionServiceInterface
     */
    private $flashPromotionService;

    /**
     * 添加活动
     * @RequestMapping(path = "create", method = {"post"})
     * @return ResponseInterface
     */
    public function create() : ResponseInterface
    {
        $flashPromotionParam = $this->transformInput($this->request->post());
        $flashPromotion = $this->flashPromotionService->create($flashPromotionParam);

        if ($flashPromotion) {
            return $this->success(1);
        } else {
            return $this->error();
        }
    }

    /**
     * 编辑活动信息
     * @RequestMapping(path = "update/{id}", method = {"post"})
     * @return ResponseInterface
     */
    public function update(int $id) : ResponseInterface
    {
        $flashPromotionParam = $this->transformInput($this->request->post());
        $count = $this->flashPromotionService->update($id, $flashPromotionParam);

        if ($count > 0) {
            return $this->success(1);
        } else {
            return $this->error();
        }
    }

    /**
     * 删除活动信息
     * @RequestMapping(path = "delete/{id}", method = {"post"})
     * @return ResponseInterface
     */
    public function delete(int $id) : ResponseInterface
    {
        $count = $this->flashPromotionService->delete($id);

        if ($count > 0) {
            return $this->success($count);
        } else {
            return $this->error();
        }
    }

    /**
     * 修改上下线状态
     * @RequestMapping(path = "update/status/{id}", method = {"post"})
     * @return ResponseInterface
     */
    public function updateStatus(int $id) : ResponseInterface
    {
        $status = $this->request->input('status');
        $count = $this->flashPromotionService->updateStatus($id, $status);

        if ($count > 0) {
            return $this->success(1);
        } else {
            return $this->error();
        }
    }

    /**
     * 获取活动详情
     * @RequestMapping(path = "{:id}", method = {"get"})
     * @return ResponseInterface
     */
    public function getItem(int $id) : ResponseInterface
    {
        $flashPromotion = $this->flashPromotionService->getItem($id);

        return $this->success($flashPromotion);
    }

    /**
     * 根据活动名称分页查询
     * @RequestMapping(path = "list", method = {"get"})
     * @return ResponseInterface
     */
    public function getList() : ResponseInterface
    {
        $keyword = (string)$this->request->input('keyword', '');
        $pageSize = (int)$this->request->input('pageSize', 5);
        $pageNum = (int)$this->request->input('pageNum', 1);

        $flashPromotionList = $this->flashPromotionService->getList($pageSize, $pageNum, ['keyword'=>$keyword]);

        return $this->success($flashPromotionList);
    }
}
