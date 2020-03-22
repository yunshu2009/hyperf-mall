<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\PmsProductAttributeCategory;

interface PmsProductAttributeCategoryServiceInterface
{
    public function create(string $name) : PmsProductAttributeCategory;

    public function update(int $id, string $name) : int;

    public function delete(int $id) : int;

    public function getItem(int $id) : array;

    public function getList(int $pageSize, int $pageNum) : array;

    public function getListWithAttr() : array;
}