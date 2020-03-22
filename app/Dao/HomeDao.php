<?php

declare(strict_types=1);

namespace App\Dao;

use Hyperf\DbConnection\Db;

class HomeDao
{
    public function getRecommendSubjectList(int $offset, int $limit) : array
    {
        $sql = " SELECT s.*
        FROM
            sms_home_recommend_subject hs
            LEFT JOIN cms_subject s ON hs.subject_id = s.id
        WHERE
            hs.recommend_status = 1
            AND s.show_status = 1
        ORDER BY
            hs.sort DESC
        LIMIT ?, ?";

        return Db::select($sql, [$offset, $limit]);
    }

    public function getHotProductList(int $offset, int $limit) : array
    {
        $sql = "        SELECT p.*
        FROM
            sms_home_recommend_product hp
            LEFT JOIN pms_product p ON hp.product_id = p.id
        WHERE
            hp.recommend_status = 1
            AND p.publish_status = 1
        ORDER BY
            hp.sort DESC
        LIMIT ?, ?";

        return Db::select($sql, [$offset, $limit]);
    }

    public function getNewProductList(int $offset, int $limit) : array
    {
        $sql = "        SELECT p.*
        FROM
            sms_home_new_product hp
            LEFT JOIN pms_product p ON hp.product_id = p.id
        WHERE
            hp.recommend_status = 1
            AND p.publish_status = 1
        ORDER BY
            hp.sort DESC
        LIMIT ?, ?";

        return Db::select($sql, [$offset, $limit]);
    }

    public function getRecommendBrandList(int $offset, int $limit) : array
    {
        $sql = "        SELECT b.*
        FROM
            sms_home_brand hb
            LEFT JOIN pms_brand b ON hb.brand_id = b.id
        WHERE
            hb.recommend_status = 1
            AND b.show_status = 1
        ORDER BY
            hb.sort DESC
        LIMIT ?, ?";

        return Db::select($sql, [$offset, $limit]);
    }

    public function getFlashProductList(int $flashPromotionId, int $sessionId)
    {
        $sql = "  SELECT
            pr.flash_promotion_price,
            pr.flash_promotion_count,
            pr.flash_promotion_limit,
            p.*
        FROM
            sms_flash_promotion_product_relation pr
            LEFT JOIN pms_product p ON pr.product_id = p.id
        WHERE
            pr.flash_promotion_id = ?
            AND pr.flash_promotion_session_id = ?";

        return Db::select($sql, [$flashPromotionId, $sessionId]);
    }
}