<?php

declare(strict_types=1);

namespace App\Service;

use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;

abstract class Service
{
    protected function transform(array $arr) : array
    {
        $newArr = [];
        foreach ($arr as  $k=>$v){
            if (is_string($k)) {
                $k = Str::camel($k);
            }
            if(is_array($v)){
                $v = $this->transform($v);
            }

            $newArr[$k] = $v;
        }

        return $newArr;
    }

    protected function getPageInfo(int $pageNum, int $pageSize, int $total) : array
    {
        $page = [];
        $page['pageNum'] = $pageNum >= 1 ? $pageNum-1 : $pageNum;
        $page['pageSize'] = ($pageSize > $total) ? $total : $pageSize;
        $page['total'] = $total;

        return $page;
    }

    /**
     * 获取redis实例
     */
    protected function getRedis(string $pool='default')
    {
        $container = ApplicationContext::getContainer();

// 通过 DI 容器获取或直接注入 RedisFactory 类
        $redis = $container->get(RedisFactory::class)->get($pool);

        return $redis;
    }
}