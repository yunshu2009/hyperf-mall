<?php

namespace App\Service;

class SmsGroupService extends Service implements SmsGroupServiceInterface
{
    public function getList(array $attributes)
    {
        $attributes['pageNum']  = $attributes['pageNum'] ?? 1;
        $attributes['pageSize'] = $attributes['pageSize'] ?? 10;

        $now = date('Y-m-d H:i:s');
        $condition = [
            ['start_time', '<', $now],
            ['end_time', '>', $now],
        ];
        $with = [
            'goods' =>  function($query) {
                $query->select('*');
            }
        ];

        return $this->queryList($condition, $attributes['pageNum'], $attributes['pageSize'], 'id', 'desc', $with);
    }
}