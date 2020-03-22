<?php

declare(strict_types=1);

namespace App\Dao;

use Hyperf\DbConnection\Db;

class CouponHistoryDao
{
    public function getDetailList(int $memberId) : array
    {
        $sql = "SELECT
            ch.*,
            c.id c_id,
            c.name c_name,
            c.amount c_amount,
            c.min_point c_min_point,
            c.platform c_platform,
            c.start_time c_start_time,
            c.end_time c_end_time,
            c.note c_note,
            c.use_type c_use_type,
            c.type c_type,
            cpr.id cpr_id,cpr.product_id cpr_product_id,
            cpcr.id cpcr_id,cpcr.product_category_id cpcr_product_category_id
        FROM
            sms_coupon_history ch
            LEFT JOIN sms_coupon c ON ch.coupon_id = c.id
            LEFT JOIN sms_coupon_product_relation cpr ON cpr.coupon_id = c.id
            LEFT JOIN sms_coupon_product_category_relation cpcr ON cpcr.coupon_id = c.id
        WHERE ch.member_id = ?
        AND ch.use_status = 0";

        $list = Db::select($sql, [$memberId]);

        return $this->couponHistoryDetailMap($list);
    }

    private function couponHistoryDetailMap($list)
    {
        $resultMap = [];

        foreach ($list as $key=>$item) {
            $resultItem = [
                'coupon'                =>  [],
                'productRelationList'   =>  [],
                'categoryRelationList'  =>  [],
            ];
            foreach ($item as $sk=>$sitem) {
                if (strpos($sk, 'c_') !== false) {
                    $key = str_replace('c_', '', $sk);
                    $resultItem['coupon'][$key] = $sitem;
                } elseif (strpos($sk, 'cpr_') !== false) {
                    if ($item['cpr_product_id']) {
                        $key  = str_replace('cpr_','', $sk);
                        $resultItem['productRelationList'][$key] = $sitem;
                    }
                } elseif (strpos($sk, 'cpcr_') !== false) {
                    if ($item['cpcr_product_category_id']) {
                        $key   = str_replace('cpcr_', '', $sk);
                        $resultItem['categoryRelationList'][$key] = $sitem;
                    }
                } else {
                    $resultItem[$sk] = $sitem;
                }
            } //

            $resultMap[] = $resultItem;
        }

        return $resultMap;
    }
}
