<?php

declare(strict_types=1);

use App\Service;
use App\Service\OmsPromotionServiceInterface;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    Service\PmsBrandServiceInterface::class                         =>  Service\PmsBrandService::class,
    Service\PmsProductAttributeCategoryServiceInterface::class      => Service\PmsProductAttributeCategoryService::class,
    Service\PmsProductAttributServiceInterface::class               => Service\PmsProductAttributService::class,
    Service\PmsProductCategoryServiceInterface::class               => Service\PmsProductCategoryService::class,
    Service\PmsProductServiceInterface::class                       =>  Service\PmsProductService::class,
    Service\PmsSkuStockServiceInterface::class                      =>  Service\PmsSkuStockService::class,
    Service\SmsCouponServiceInterface::class                        =>  Service\SmsCouponService::class,
    Service\SmsFlashPromotionServiceInterface::class                =>  Service\SmsFlashPromotionService::class,
    Service\SmsFlashPromotionProductRelationServiceInterface::class => Service\SmsFlashPromotionProductRelationService::class,
    Service\HomeServiceInterface::class                             =>  Service\HomeService::class,
    Service\OmsCartItemServiceInterface::class                      =>  Service\OmsCartItemService::class,
    Service\UmsMemberServiceInterface::class                        =>  Service\UmsMemberService::class,
    Service\UmsMemberCouponServiceInterface::class                  =>  Service\UmsMemberCouponService::class,
    Service\OmsPromotionServiceInterface::class                     =>  Service\OmsPromotionService::class,
    Service\UmsMemberReceiveAddressServiceInterface::class          =>  Service\UmsMemberReceiveAddressService::class,
    Service\OmsPortalOrderServiceInterface::class                   => Service\OmsPortalOrderService::class,
    Service\UmsMemberCollectionServiceInterface::class              => Service\UmsMemberCollectionService::class
];
