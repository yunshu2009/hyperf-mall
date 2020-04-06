<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\PmsProduct;

interface PmsProductServiceInterface
{
    public function create(array $pmsProductParam) : ?PmsProduct;

    public function getUpdateInfo(int $id) : array;

    public function update($id, $productParam) : int;

    public function simpleList(string $keyword) : array;

    public function updateVerifyStatus(array $ids, int $verifyStatus) : int;

    public function updatePublishStatus(array $ids, int $publishStatus) : int;

    public function updateRecommendStatus(array $ids, int $recommendStatus) : int;

    public function updateNewStatus(array $ids, int $newStatus) : int;

    public function updateDeleteStatus(array $ids, int $deleteStatus) : int;

    public function getItem(int $id) : ?PmsProduct;
}
