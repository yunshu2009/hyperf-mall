<?php

declare(strict_types=1);

namespace App\Service\Admin\Pms;

use App\Model\CmsPrefrenceAreaProductRelation;
use App\Model\CmsSubjectProductRelation;
use App\Model\PmsProductAttributeValue;
use App\Model\PmsMemberPrice;
use App\Model\PmsProduct;
use App\Model\PmsProductLadder;
use App\Model\PmsProductFullReduction;
use App\Model\PmsSkuStock;
use App\Service\Service;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Arr;

class ProductService extends Service implements ProductServiceInterface
{
    protected $model = 'PmsProduct';

    public function create(array $pmsProductParam) : ?PmsProduct
    {
        $pmsProduct = null;
        try {
            Db::beginTransaction();
            $pmsProductParam = Arr::except($pmsProductParam, 'id');
            $pmsProduct = PmsProduct::create($pmsProductParam);
            // 会员价格
            $memberPriceList = $pmsProductParam['member_price_list'] ?? [];
            $this->relateAndInsertList($pmsProduct['id'], $memberPriceList, function($dataList) {
//                var_dump($dataList);
                PmsMemberPrice::create($dataList);
            });
            // 阶梯价格
            $productLadderList = $pmsProductParam['product_ladder_list'] ?? [];
            $this->relateAndInsertList($pmsProduct['id'], $productLadderList, function ($dataList) {
                PmsProductLadder::create($dataList);
            });
            // 满减价格
            $productFullReductionList = $pmsProductParam['product_full_reduction_list'] ?? [];
            $this->relateAndInsertList($pmsProduct['id'], $productFullReductionList, function ($dataList) {
                PmsProductFullReduction::create($dataList);
            });
            // 添加sku库存信息
            $skuStockList = $pmsProductParam['sku_stock_list'] ?? [];
            $this->relateAndInsertList($pmsProduct['id'], $skuStockList, function ($dataList) {
//                var_dump($dataList);
                PmsSkuStock::create($dataList);
            });
            // 添加商品参数,添加自定义商品规格
            $productAttributeValueList = $pmsProductParam['product_attribute_value_list'] ?? [];
            $this->relateAndInsertList($pmsProduct['id'], $productAttributeValueList, function ($dataList) {
                PmsProductAttributeValue::create($dataList);
            });
            // 关联专题
            $subjectProductRelationList = $pmsProductParam['subject_product_relation_list'] ?? [];
            $this->relateAndInsertList($pmsProduct['id'], $subjectProductRelationList, function ($dataList) {
                CmsSubjectProductRelation::create($dataList);
            });
            // 关联优选
            $prefrenceAreaProductRelationList = $pmsProductParam['prefrence_area_product_relation_list'] ?? [];
            $this->relateAndInsertList($pmsProduct['id'], $prefrenceAreaProductRelationList, function ($dataList) {
                CmsPrefrenceAreaProductRelation::create($dataList);
            });

            Db::commit();
        } catch (\Throwable $ex) {
            Db::rollBack();
            throw $ex;
        }

        return $pmsProduct;
    }

    private function relateAndInsertList($productId, $dataList, $callback) : void
    {
        if (empty($dataList)) {
          return;  // 不做处理
        }

        foreach ($dataList as $k=>$item) {
            $item['id'] = null;
            $item['product_id'] = $productId;

            call_user_func($callback, $item);
        }
    }

    // todo：完善
    public function getUpdateInfo(int $id) : array
    {
        $sql = "        SELECT *,
            pc.parent_id cateParentId,
            l.id ladder_id,l.product_id ladder_product_id,l.discount ladder_discount,l.count ladder_count,l.price ladder_price,
            pf.id full_id,pf.product_id full_product_id,pf.full_price full_full_price,pf.reduce_price full_reduce_price,
            m.id member_id,m.product_id member_product_id,m.member_level_id member_member_level_id,m.member_price member_member_price,m.member_level_name member_member_level_name,
            s.id sku_id,s.product_id sku_product_id,s.price sku_price,s.low_stock sku_low_stock,s.pic sku_pic,s.sale sku_sale,s.sku_code sku_sku_code,s.sp1 sku_sp1,s.sp2 sku_sp2,s.sp3 sku_sp3,s.stock sku_stock,
            a.id attribute_id,a.product_id attribute_product_id,a.product_attribute_id attribute_product_attribute_id,a.value attribute_value
        FROM pms_product p
        LEFT JOIN pms_product_category pc on pc.id = p.product_category_id
        LEFT JOIN pms_product_ladder l ON p.id = l.product_id
        LEFT JOIN pms_product_full_reduction pf ON pf.product_id=p.id
        LEFT JOIN pms_member_price m ON m.product_id = p.id
        LEFT JOIN pms_sku_stock s ON s.product_id = p.id
        LEFT JOIN pms_product_attribute_value a ON a.product_id=p.id
        WHERE p.id=:id";

        return $this->transform(Db::select($sql, [$id]));
    }

    public function update($id, $productParam) : int
    {
        return 1;
    }

    public function simpleList(string $keyword) : array
    {
        return [];
    }

    public function updateVerifyStatus(array $ids, int $verifyStatus) : int
    {
        return 0;
    }

    public function updatePublishStatus(array $ids, int $publishStatus) : int
    {
        return 0;
    }

    public function updateRecommendStatus(array $ids, int $recommendStatus) : int
    {
        return 0;
    }

    public function updateNewStatus(array $ids, int $newStatus) : int
    {
        return 0;
    }

    public function updateDeleteStatus(array $ids, int $deleteStatus) : int
    {
        return 0;
    }

    public function getItem(int $id) : object
    {
        return PmsProduct::where('id', $id)->first();
    }
}
