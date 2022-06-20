<?php

declare(strict_types=1);

namespace App\Service\Admin\Pms;

use App\Model\PmsProductAttribute;

interface ProductAttributServiceInterface
{
    public function getList(int $cid, int $type, int $pageSize, int $pageNum) : array;

    public function create(array $pmsProductAttributeParam) : ?PmsProductAttribute;

    public function update(int $id, array $pmsProductAttributeParam) : int;

    public function getItem(int $id) : PmsProductAttribute;

    public function delete(array $ids) : int;

    public function getProductAttrInfo(int $productCategoryId) : array;
}
