<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsCouponProductRelation extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // sms_coupon_product_relation 优惠券和产品的关系表
        Schema::create('sms_coupon_product_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('coupon_id')->nullable(false);
            $table->bigInteger('product_id')->nullable(false);
            $table->string('product_name', 64)->nullable(false)->comment('商品名称');
            $table->string('product_sn', 64)->nullable(false)->comment('商品编码');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_coupon_product_relation');
    }
}
