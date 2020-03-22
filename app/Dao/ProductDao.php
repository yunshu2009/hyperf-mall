<?php

declare(strict_types=1);

namespace App\Dao;

use Hyperf\DbConnection\Db;

class ProductDao
{
    public function getPromotionProductList($productIds)
    {
        $sql = "  SELECT
            p.id,
            p.`name`,
            p.promotion_type,
            p.gift_growth,
            p.gift_point,
            sku.id sku_id,
            sku.price sku_price,
            sku.sku_code sku_sku_code,
            sku.promotion_price sku_promotion_price,
            sku.stock sku_stock,
            sku.lock_stock sku_lock_stock,
            ladder.id ladder_id,
            ladder.count ladder_count,
            ladder.discount ladder_discount,
            full_re.id full_id,
            full_re.full_price full_full_price,
            full_re.reduce_price full_reduce_price
        FROM
            pms_product p
            LEFT JOIN pms_sku_stock sku ON p.id = sku.product_id
            LEFT JOIN pms_product_ladder ladder ON p.id = ladder.product_id
            LEFT JOIN pms_product_full_reduction full_re ON p.id = full_re.product_id
        WHERE
            p.id IN (?)";

        $list = Db::select($sql, [$productIds]);

        return $this->getPromotionProductResultMap($list);
    }

    public function getPromotionProductResultMap(array $list)
    {
         $pmsProductMap = [];
         $pmsSkuStockMap = [];
         $pmsProductLadderMap = [];
         $pmsProductFullReductionMap = [];
         foreach ($list as $key=>$item) {
             if (strpos($key, 'sku_') !== false) {
                $key = str_replace('sku_', '', $key);
                $pmsSkuStockMap[$key] = $item;
             } elseif (strpos($key, 'ladder_') !== false) {
                $key = str_replace('ladder_', '', $key);
                $pmsProductLadderMap[$key] = $item;
             } elseif (strpos($key, 'full_') !== false) {
                 $key = str_replace('full_', '', $key);
                 $pmsProductFullReductionMap[$key] = $item;
             } else {
                 $pmsProductMap[$key] = $item;
             }
         }

         return array_merge($pmsProductMap, ['skuStockList'=>$pmsSkuStockMap], ['productLadderList'=>$pmsProductLadderMap], ['productFullReductionList'=>$pmsProductFullReductionMap]);
    }

    public function getCartProduct($productId)
    {
        $sql = "        SELECT
            p.id id,
            p.`name` name,
            p.sub_title subTitle,
            p.price price,
            p.pic pic,
            p.product_attribute_category_id productAttributeCategoryId,
            p.stock stock,
            pa.id attr_id,
            pa.`name` attr_name,
            ps.id sku_id,
            ps.sku_code sku_code,
            ps.price sku_price,
            ps.sp1 sku_sp1,
            ps.sp2 sku_sp2,
            ps.sp3 sku_sp3,
            ps.stock sku_stock,
            ps.pic sku_pic
        FROM
            pms_product p
            LEFT JOIN pms_product_attribute pa ON p.product_attribute_category_id = pa.product_attribute_category_id
            LEFT JOIN pms_sku_stock ps ON p.id=ps.product_id
        WHERE
            p.id = ?
            AND pa.type = 0
        ORDER BY pa.sort desc"; // pa.type=0 规格 pa.type=1参数

        return Db::select($sql, [$productId]);
    }
}