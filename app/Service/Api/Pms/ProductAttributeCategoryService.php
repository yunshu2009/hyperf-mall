<?php

declare(strict_types=1);

namespace App\Service\Api\Pms;

use App\Model\PmsProductAttribute;
use App\Model\PmsProductAttributeCategory;
use App\Service\Service;

class ProductAttributeCategoryService extends Service implements ProductAttributeCategoryServiceInterface
{
    protected $model = 'PmsProductAttributeCategory';

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
