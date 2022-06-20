<?php

declare(strict_types=1);

namespace App\Service\Admin\Pms;

use App\Model\PmsProductCategory;

interface ProductCategoryServiceInterface
{
    public function create(array $productCategoryParam) : ?PmsProductCategory;

    public function update(int $id, array $productCategoryParam) : int;

    public function getList(int $parentId, int $pageSize, int $pageNum) : array;

    public function getItem(int $id) : PmsProductCategory;

    public function delete(int $id) : int;

    public function updateNavStatus(array $ids, int $navStatus) : int;

    public function updateShowStatus(array $ids, int $navStatus) : int;

    public function listWithChildren() : array;
}
