<?php

namespace App\Service\Api;

use App\Service\Service;
use Hyperf\Di\Annotation\Inject;

class MemberCollectionService extends Service implements MemberCollectionServiceInterface
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
        return $count;
    }
}
