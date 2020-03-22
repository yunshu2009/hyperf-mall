<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\PmsProduct;
use App\Model\PmsProductCategory;
use App\Model\PmsProductCategoryAttributeRelation;
use Hyperf\DbConnection\Db;

class PmsProductCategoryService extends Service implements PmsProductCategoryServiceInterface
{
    public function create(array $productCategoryParam) : ?PmsProductCategory
    {
        $productCategory = null;

        Db::beginTransaction();
        try {
            // 添加商品分类
            $productCategoryParam['product_count'] = $productCategoryParam;

            $productCategoryParam
                = $this->setCategoryLevel($productCategoryParam);

            $productCategory
                = PmsProductCategory::create($productCategoryParam);

            // 创建筛选属性关联
            $productAttributeIdList
                = $productCategoryParam['product_attribute_id_list'] ?? [];
            if ( ! empty($productAttributeIdList)) {
                $this->insertRelationList($productCategory->id,
                    $productAttributeIdList);
            }
            Db::commit();
        } catch (\Throwable $ex) {
            Db::rollBack();
        }

        return $productCategory;
    }

    private function setCategoryLevel(array $productCategory)
    {
        if ($productCategory['parent_id'] == 0) {
            $productCategory['level'] =0;
        } else {
            $parentCategory = PmsProductCategory::where('id', $productCategory['parent_id'])->first();
            if ($parentCategory) {
                $productCategory['level'] = $parentCategory['level'] + 1;
            } else {
                $productCategory['level'] = 0;
            }
        }

        return $productCategory;
    }

    private function insertRelationList(int $productCategoryId, array $productAttributeIdList)
    {
        $relationList = [];

        foreach ($productAttributeIdList as $productAttributeId) {
            $relation = [];
            $relation['product_category_id'] = $productCategoryId;
            $relation['product_attribute_id'] = $productAttributeId;
            $relationList[] = $relation;
        }

        PmsProductCategoryAttributeRelation::insert($relation);
    }

    public function update(int $id, array $productCategoryParam) : int
    {
        $count = 0;

        Db::beginTransaction();
        try {
            $productCategoryParam
                = $this->setCategoryLevel($productCategoryParam);

            // 更新商品分类时要更新商品中的名称
            PmsProduct::where('product_category_id', $id)->update([
                'product_category_name' => $productCategoryParam['name'],
            ]);

            // 同时更新筛选属性的信息
            $productAttributeIdList
                = $productCategoryParam['product_attribute_id_list'] ?? [];
            if ( ! empty($productAttributeIdList)) {
                // 删除之前属性关联信息
                PmsProductCategoryAttributeRelation::where('product_category_id',
                    $id)->delete();
                // 添加属性关联
                $this->insertRelationList($productCategoryParam['id'],
                    $productAttributeIdList);
            } else {
                // 删除属性关联
                PmsProductCategoryAttributeRelation::where('product_category_id',
                    $id)->delete();
            }

            $count = PmsProductCategory::where('id', $id)
                                     ->update($productCategoryParam);
            Db::commit();
        } catch (\Throwable $ex) {
            Db::rollBack();
        }

        return $count;
    }

    public function getList(int $parentId, int $pageSize, int $pageNum) : array
    {
        $total = PmsProductCategory::where('parent_id', $parentId)->count();

        $page = $this->getPageInfo($pageNum, $pageSize, $total);

        $list = PmsProductCategory::where('parent_id', $parentId)
                       ->skip((int)($page['pageNum']*$page['pageSize']))
                       ->take((int)$page['pageSize'])
                       ->orderBy('sort', 'desc')
                       ->get()
                       ->toArray();
        $page['list'] = $this->transform($list);

        return $page;
    }

    public function getItem(int $id) : PmsProductCategory
    {
        return PmsProductCategory::where('id', $id)->first();
    }

    public function delete(int $id) : int
    {
        return PmsProductCategory::destroy($id);
    }

    public function updateNavStatus(array $ids, int $navStatus) : int
    {
        return PmsProductCategory::whereIn('id', $ids)->update(['nav_status'=>$navStatus]);
    }

    public function updateShowStatus(array $ids, int $navStatus) : int
    {
        return PmsProductCategory::whereIn('id', $ids)->update(['show_status'=>$navStatus]);
    }

    public function listWithChildren() : array
    {
        $sql = "select
            c1.id,
            c1.name,
            c2.id   child_id,
            c2.name child_name
        from pms_product_category c1 left join pms_product_category c2 on c1.id = c2.parent_id
        where c1.parent_id = 0";

        return Db::select($sql);
    }
}
