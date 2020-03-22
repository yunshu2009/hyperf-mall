<?php

declare(strict_types=1);

namespace App\Service;

use App\Constants\ResultCode;
use App\Exception\BusinessException;
use App\Model\PmsProductAttribute;
use App\Model\PmsProductAttributeCategory;
use Hyperf\DbConnection\Db;

class PmsProductAttributService extends Service implements PmsProductAttributServiceInterface
{
    public function getList(int $cid, int $type, int $pageSize, int $pageNum) : array
    {
        $where = ['product_attribute_category_id'=>$cid, 'type'=>$type];

        $total = PmsProductAttribute::where($where)->count();

        $page = $this->getPageInfo($pageNum, $pageSize, $total);

        $page['list'] = $this->transform(PmsProductAttribute::where($where)
                                                 ->orderBy('sort', 'desc')
                                                 ->skip($page['pageNum']*$page['pageSize'])
                                                 ->take($page['pageSize'])
                                                 ->get()
                                                 ->toArray());

        return $page;
    }

    public function create(array $pmsProductAttributeParam) : ?PmsProductAttribute
    {
        $pmsProductAttribute = null;

        Db::beginTransaction();
        try {
            $pmsProductAttributeCategory = PmsProductAttributeCategory::find($pmsProductAttributeParam['product_attribute_category_id']);

            if (! $pmsProductAttributeCategory) {
                throw new BusinessException(ResultCode::FAILED, '商品属性分类不存在');
            }

            $pmsProductAttribute = PmsProductAttribute::create($pmsProductAttributeParam);

            // todo:定时同步属性分类表规格/参数数量
            if ($pmsProductAttribute) {
                // 新增商品属性以后需要更新商品属性分类数量
                if ($pmsProductAttribute['type'] == 0) {   // 规格
                    $pmsProductAttributeCategory->increment('attribute_count');
                } else {  // 属性
                    $pmsProductAttributeCategory->increment('param_count');
                }
            }
            Db::commit();
        } catch (\Throwable $ex ) {
            Db::rollback();
        }
        
        return $pmsProductAttribute;
    }

    public function update(int $id, array $pmsProductAttributeParam) : int
    {
        $count = PmsProductAttribute::where('id', $id)->update($pmsProductAttributeParam);

        //todo:定时同步属性/规格数量

        return $count;
    }

    public function getItem(int $id) : PmsProductAttribute
    {
        $pmsProductAttribute = PmsProductAttribute::where('id', $id)->first();

        return $pmsProductAttribute;
    }

    public function delete(array $ids) : int
    {
        $pmsProductAttribute = PmsProductAttribute::where('id', current($ids))->first();

        $count = PmsProductAttribute::destroy($ids);

        // 删除完成后修改数量
        $pmsProductAttributeCategory = PmsProductAttributeCategory::where('id', $pmsProductAttribute->product_attribute_category_id)->first();

        if ($pmsProductAttributeCategory->type == 0) { // 规格
            if ($pmsProductAttributeCategory->attribute_count >= $count) {
                $pmsProductAttributeCategory->attribute_count = $pmsProductAttributeCategory->attribute_count - $count;
            } else {
                $pmsProductAttributeCategory->attribute_count = 0;
            }
        } else { // 属性
            if ($pmsProductAttributeCategory->param_count >= $count) {
                $pmsProductAttributeCategory->param_count = $pmsProductAttributeCategory->param_count - $count;
            } else {
                $pmsProductAttributeCategory->param_count = 0;
            }
        }
        $pmsProductAttributeCategory->save();

        return $count;
    }

    public function getProductAttrInfo(int $productCategoryId) : array
    {
        $sql = "        SELECT
            pa.id  attributeId,
            pac.id attributeCategoryId
        FROM
            pms_product_category_attribute_relation pcar
            LEFT JOIN pms_product_attribute pa ON pa.id = pcar.product_attribute_id
            LEFT JOIN pms_product_attribute_category pac ON pa.product_attribute_category_id = pac.id
        WHERE
            pcar.product_category_id = ?";
        return Db::select($sql, [$productCategoryId]);
    }
}
