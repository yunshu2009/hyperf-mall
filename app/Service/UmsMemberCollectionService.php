<?php

namespace App\Service;

use Hyperf\Di\Annotation\Inject;

class UmsMemberCollectionService extends Service implements UmsMemberCollectionServiceInterface
{
    /**
     * @Inject()
     * @var \App\Repository\MemberProductCollectionRepository
     */
    private $productCollectionRepository;

    public function addProduct($productCollection)
    {
        $count = 0;
        $memberProductCollection = $this->productCollectionRepository->findByMemberIdAndProductId($productCollection['member_id'], $productCollection['product_id']);

        if (is_null($memberProductCollection)) {
            $this->productCollectionRepository->save($productCollection);
            $count = 1;
        }
        return count;
    }
}