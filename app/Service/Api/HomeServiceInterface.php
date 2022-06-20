<?php
declare(strict_types=1);

namespace App\Service\Api;

interface HomeServiceInterface
{
    public function getContent() : array;

    public function getProductCateList(int $parentId) : array;

    public function recommendProductList($pageSize, $pageNum) : array;

    public function getSubjectList(int $cateId, int $pageSize, int $pageNum) : array;
}
