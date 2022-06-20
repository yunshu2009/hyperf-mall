<?php

declare(strict_types=1);

namespace App\Service\Admin\Pms;

use App\Model\PmsBrand;
use App\Model\PmsProduct;
use App\Service\Service;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Arr;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class BrandService extends Service implements BrandServiceInterface
{
    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    public function listAllBrand() : array
    {
        $brands = $this->transform(PmsBrand::all()->toArray());

        return $brands;
    }

    public function createBrand(array $pmsBrand) : PmsBrand
    {
        $pmsBrand = PmsBrand::create($pmsBrand);

        return $pmsBrand;
    }

    public function updateBrand(int $id, array $pmsBrandParams) : int
    {
        $count = 0;
        try {
            Db::beginTransaction();
            $pmsBrandParams = Arr::except($pmsBrandParams, 'id');

            // 更新品牌时要更新商品中的品牌名称
            PmsProduct::where(['brand_id' => $id])->update([
                'brand_name' => $pmsBrandParams['name'],
            ]);

            $count = PmsBrand::where(['id' => $id])->update($pmsBrandParams);
            Db::commit();
        } catch (\Throwable $ex) {
            Db::rollBack();
        }

        return $count;
    }

    public function deleteBrand(int $id) : int
    {
        $count = PmsBrand::destroy($id);

        return $count;
    }

    public function deleteBrands(array $ids) : int
    {
        $count = PmsBrand::destroy($ids);

        return $count;
    }

    public function listBrand(string $keyword, int $pageNum, int $pageSize) : array
    {
        $where = [];
        if ($keyword) {
            $where[] = ['brand', 'like', '%'.$keyword.'%'];
        }

        $total = PmsBrand::where($where)->count();

        $page = $this->getPageInfo($pageNum, $pageSize, $total);

        $page['list'] = $this->transform(PmsBrand::where($where)
            ->orderBy('sort', 'desc')
            ->skip($page['pageNum']*$page['pageSize'])
            ->take($page['pageSize'])
            ->get()
            ->toArray());

        return $page;
    }

    public function getBrand(int $id) : PmsBrand
    {
        $brand = PmsBrand::find($id);

        return $brand;
    }

    public function updateShowStatus($ids, $showStatus) : int
    {
        $count = PmsBrand::whereIn('id', $ids)->update([
            'show_status'   =>  $showStatus,
        ]);

        return $count;
    }

    public function updateFactoryStatus($ids, $factoryStatus) : int
    {
        $count = PmsBrand::whereIn('id', $ids)->update([
            'factory_status'   =>  $factoryStatus,
        ]);

        return $count;
    }
}
