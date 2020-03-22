<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsCouponProductCategoryRelation extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // sms_coupon_product_category_relation 优惠券和产品分类关系表
        Schema::create('sms_coupon_product_category_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('coupon_id')->nullable(false);
            $table->bigInteger('product_category_id')->nullable(false);
            $table->string('product_category_name', 64)->nullable(false)->comment('商品分类');
            $table->string('parent_category_name', 64)->nullable(false)->comment('父分类名称');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_coupon_product_category_relation');
    }
}
