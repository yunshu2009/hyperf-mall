<?php

declare(strict_types=1);

namespace App\Service;

use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;

abstract class Service
{
    protected $model;

    protected function queryList($condition=[], $pageNum=0, $pageSize=0, $order='id', $sort='desc', $with=[], $select=[]) : array
    {
        $list = [];
        $class = '\\App\\Model\\'.$this->model;
        $model = new $class;

        $query = $model->query();

        if ($with) {
            $query->with($with);
        }
        if ($condition) {
            $query->where($condition);
        }
        if ($pageNum && $pageSize) {
            $total = $query->count();
            $page = $this->getPageInfo($pageNum, $pageSize, $total);
            $query =  $query->skip((int)($page['pageNum']*$page['pageSize']))->take((int)$page['pageSize']);
            $list = $page;
        }
        if ($order && $sort) {
            $query = $query->orderBy($order, $sort);
        }
        $select = $select ? $select : $this->select;
        if ($select) {
            $query = $query->select($select);
        }
        $obj = $query->get();
        $list['list'] =  $obj ? $obj->toArray() : [];

        return $list;
    }

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