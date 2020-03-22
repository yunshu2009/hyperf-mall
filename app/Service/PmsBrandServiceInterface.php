<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\PmsBrand;

interface PmsBrandServiceInterface
{
    public function listAllBrand() : array;

    public function createBrand(array $pmsBrand) : PmsBrand;

    public function updateBrand(int $id, array $pmsBrandParams) : int;

    public function deleteBrand(int $id) : int;

    public function deleteBrands(array $ids) : int;

    public function listBrand(string $keyword, int $pageNum, int $pageSize) : array;

    public function getBrand(int $id) : PmsBrand;

    public function updateShowStatus($ids, $showStatus) : int;

    public function updateFactoryStatus($ids, $factoryStatus) : int;
}
