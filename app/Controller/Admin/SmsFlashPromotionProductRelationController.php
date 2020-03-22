<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\SmsFlashPromotionServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

class SmsFlashPromotionProductRelationController
{
    /**
     * @Inject()
     * @var \App\Service\SmsFlashPromotionProductRelationServiceInterface
     */
    private $flashPromotionProductRelationService;


}
