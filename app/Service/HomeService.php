<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\CmsSubject;
use App\Model\PmsBrand;
use App\Model\PmsProduct;
use App\Model\PmsProductCategory;
use App\Model\SmsFlashPromotion;
use App\Model\SmsFlashPromotionSession;
use Carbon\Carbon;
use Hyperf\Di\Annotation\Inject;
use App\Model\SmsHomeAdvertise;

class HomeService extends Service implements HomeServiceInterface
{
    /**
     * @Inject
     * @var \App\Dao\HomeDao
     */
    private $homeDao;

    /**
     * @return array
     */
    public function getContent(): array
    {
        $homeResult = [
            'advertiseList'         =>  [],  // 轮播广告
            'brandList'             =>  [], // 推荐品牌
            'homeFlashPromotion'    =>  [], // 当前秒杀场次
            'newProductList'        =>  [], // 新品推荐
            'hotProductList'        =>  [], // 人气推荐
            'subjectList'           =>  [], // 推荐专题
        ];

        // 获取首页广告
        $homeResult['advertiseList'] = $this->getHomeAdvertiseList();
        // 获取推荐品牌
        $homeResult['brandList'] = $this->homeDao->getRecommendBrandList(0, 4);
        // 获取秒杀信息
        $homeResult['homeFlashPromotion'] = $this->getHomeFlashPromotion(0, 4);
        // 获取新品推荐
        $homeResult['newProductList'] = $this->homeDao->getNewProductList(0, 4);
        // 获取人气推荐
        $homeResult['hotProductList'] = $this->homeDao->getHotProductList(0, 4);
        // 获取推荐专题
        $homeResult['subjectList'] = $this->homeDao->getRecommendSubjectList(0, 4);

        return $this->transform($homeResult);
    }

    private function getHomeAdvertiseList() : array
    {
        $advertiseList = SmsHomeAdvertise::where(['type'=>1, 'status'=>1])
                        ->orderBy('sort', 'desc')
                        ->get()
                        ->toArray();

        return $advertiseList;
    }

    private function getHomeFlashPromotion($offset, $limit)
    {
        $homeFlashPromotion = [];

//        $currDate = date('Y-m-d');
//        $currTime = date('H:i:s', time());
        $currDate = '2018-11-16';
        $currTime = '2018-11-16 13:00:00';

        $flashPromotion = $this->getFlashPromotion($currDate);
        if ($flashPromotion) {
            $homeFlashPromotion = [
                'startTime'     => '',
                'endTime'       => '',
                'nextStartTime' => '',
                'nextEndTime'   => '',
                // 属于该秒杀活动的商品
                'productList'   => []
            ];

            // 获取当前秒杀场次
            $flashPromotionSession = $this->getFlashPromotionSession($currTime);
            if ($flashPromotion) {
                $homeFlashPromotion['startTime'] = $flashPromotionSession['start_time'];
                $homeFlashPromotion['endTime'] = $flashPromotionSession['end_time'];
                // 获取下一个秒杀场次
                $nextSession = $this->getNextFlashPromotionSession($homeFlashPromotion['startTime']);
                if ($nextSession != null) {
                    $homeFlashPromotion['nextStartTime'] = $nextSession['start_time'];
                    $homeFlashPromotion['nextEndTime'] = $nextSession['end_time'];
                }
                // 获取秒杀商品
                $flashProductList = $this->homeDao->getFlashProductList($flashPromotion['id'], $flashPromotionSession['id']);
                $homeFlashPromotion['productList'] = $flashProductList;
            }
        }

        return $homeFlashPromotion;
    }

    private function getNextFlashPromotionSession(string $startTime)
    {
        $promotionSessionList = SmsFlashPromotionSession::where('start_time', '>', $startTime)
                                ->orderBy('start_time', 'asc')
                                ->get();

        if ($promotionSessionList) {
            return $promotionSessionList[0];
        } else {
            return null;
        }
    }

    // 根据当前时间获取秒杀活动
    private function getFlashPromotion(string $currDate) : ?SmsFlashPromotion
    {
        return SmsFlashPromotion::where(['status'    =>  1])
                                ->where('start_date', '<=', $currDate)
                                ->where('end_date', '>=', $currDate)
                                ->first();
    }

    private function getFlashPromotionSession(string $currTime) : ?SmsFlashPromotionSession
    {
        return SmsFlashPromotionSession::where('start_time', '<=', $currTime)
                                        ->where('end_time', '>=', $currTime)
                                        ->first();
    }

    public function getProductCateList(int $parentId) : array
    {
        $productCateList = PmsProductCategory::where('parent_id', $parentId)
                        ->where('show_status', 1)
                        ->orderBy('sort', 'desc')
                        ->get()
                        ->toArray();

        return $this->transform($productCateList);
    }

    public function recommendProductList($pageSize, $pageNum) : array
    {
        $where = [
            'delete_status' =>  0,
            'publish_status' =>  1
        ];
        $total = PmsProduct::where($where)->count();
        $page = $this->getPageInfo($pageNum, $pageSize, $total);

        $productList = PmsProduct::where($where)
                    ->skip($page['pageNum']*$page['pageSize'])
                    ->take($page['pageSize'])
                    ->get()
                    ->toArray();

        return $this->transform($productList);
    }

    public function getSubjectList(int $cateId, int $pageSize, int $pageNum) : array
    {
        $where['show_status'] = 1;
        if ($cateId) {
            $where['category_id'] = $cateId;
        }
        $total = CmsSubject::where($where)->count();

        $page = $this->getPageInfo($pageNum, $pageSize, $total);

        $list = $this->transform(CmsSubject::where($where)
                                         ->orderBy('id', 'desc')
                                         ->skip($page['pageNum']*$page['pageSize'])
                                         ->take($page['pageSize'])
                                         ->get()
                                         ->toArray());

        return $list;
    }
}
