<?php

namespace App\Service;

class SmsGroupService extends Service implements SmsGroupServiceInterface
{
    protected $model = 'SmsGroup';
    protected $select = ['id', 'goods_id', 'goods_name', 'origin_price', 'group_price', 'start_time', 'end_time', 'hours', 'peoples'];

    public function getList(array $attributes)
    {
        $attributes['pageNum']  = (int)$attributes['pageNum'] ?? 1;
        $attributes['pageSize'] = (int)$attributes['pageSize'] ?? 10;

        $now = date('Y-m-d H:i:s');
        $condition = [
            ['start_time', '<', $now],
            ['end_time', '>', $now],
        ];
        $with = [
            'goods' =>  function($query) {
                $query->select(['id', 'name', 'pic', 'product_sn']);
            }
        ];

        return $this->queryList($condition, $attributes['pageNum'], $attributes['pageSize'], 'id', 'desc', $with);
    }
}