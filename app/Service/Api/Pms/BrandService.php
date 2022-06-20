<?php

declare(strict_types=1);

namespace App\Service\Api\Pms;

use App\Model\PmsBrand;
use App\Model\PmsProduct;
use App\Service\Service;
use Hyperf\DbConnection\Db;

class BrandService extends Service implements BrandServiceInterface
{
    /**
     * 获取推荐列表
     * @param int $pageNum
     * @param int $pageSize
     *
     * @return array
     */
    public function recommendList(int $pageNum, int $pageSize) : array
    {
        return Db::table('sms_home_brand')
                    ->leftJoin('pms_brand', 'sms_home_brand.brand_id', '=', 'pms_brand.id')
                   ->where('sms_home_brand.recommend_status', 1)
                   ->where('pms_brand.show_status', 1)
                   ->orderBy('sms_home_brand.sort', 'desc')
                   ->skip(($pageNum-1)*$pageSize)
                   ->take($pageSize)
                   ->get()
                   ->toArray();
    }


    /**
     * 获取品牌详情
     * @param int $pageNum
     * @param int $pageSize
     *
     * @return array
     */
    public function detail(int $brandId)
    {
        return PmsBrand::where('id', $brandId)->get();
    }

    /**
     * @param int $brandId
     * @param int $pageNum
     * @param int $pageSize
     *
     * @return array
     */
    public function productList(int $brandId, int $pageNum, int $pageSize) : array
    {
        return PmsProduct::where('brand_id', $brandId)
                        ->where('delete_status', 0)
                        ->skip(($pageNum-1)*$pageSize)
                        ->take($pageSize)
                        ->get()
                        ->toArray();
    }
}
