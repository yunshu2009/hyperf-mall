<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\PmsProductAttribute;
use App\Model\PmsProductAttributeCategory;
use Hyperf\DbConnection\Db;

class PmsProductAttributeCategoryService extends Service implements PmsProductAttributeCategoryServiceInterface
{
    public function create(string $name) : PmsProductAttributeCategory
    {
        $productAttributeCategory = PmsProductAttributeCategory::create([
            'name'  =>  $name
        ]);

        return $productAttributeCategory;
    }

    public function update(int $id, string $name) : int
    {
        $count = PmsProductAttributeCategory::where(['id'=>$id])->update([
            'name'  =>  $name
        ]);

        return $count;
    }

    public function delete(int $id) : int
    {
        return PmsProductAttributeCategory::destroy($id);
    }

    public function getItem(int $id) : array
    {
        $pmsProductAttributeCategory = $this->transform(PmsProductAttributeCategory::find($id)->toArray());

        return $pmsProductAttributeCategory;
    }

    public function getList(int $pageSize, int $pageNum) : array
    {
        $total = PmsProductAttributeCategory::query()->count();

        $page = $this->getPageInfo($pageNum, $pageSize, $total);

        $page['list'] = $this->transform(PmsProductAttributeCategory::query()
                        ->skip((int)($page['pageNum']*$page['pageSize']))
                        ->take((int)$page['pageSize'])
                        ->get()
                        ->toArray());

        return $page;
    }

    public function getListWithAttr() : array
    {
        $productAttributeCategory = PmsProductAttributeCategory::all()->toArray();

        if ($productAttributeCategory) {
            $ids = collect($productAttributeCategory)->pluck('id')->toArray();

            $productAttributeList = PmsProductAttribute::whereIn('product_attribute_category_id', $ids)
                                            ->get()
                                            ->toArray();

            foreach ($productAttributeCategory as $k=>$v) {
                $tmp = [];
                foreach ($productAttributeList as $productAttribute) {
                    if ($productAttribute['product_attribute_category_id'] == $v['id']) {
                        if ($productAttribute['type'] == 1) {     // 只添加属性至该分类
                            $tmp[] = $productAttribute;
                        }
                    }
                }
                $productAttributeCategory[$k]['productAttributeList'] = $tmp;
            }
        }

        return $this->transform($productAttributeCategory);
    }
}
