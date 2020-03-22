<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsCoupon extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_coupon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type')->comment('优惠卷类型；0->全场赠券；1->会员赠券；2->购物赠券；3->注册赠券');
            $table->string('name', 100);
            $table->tinyInteger('platform')->comment('使用平台：0->全部；1->移动；2->PC');
            $table->integer('count')->comment('数量');
            $table->decimal('amount', 10, 2)->comment('金额');
            $table->integer('per_limit')->comment('每人限领张数');
            $table->decimal('min_point')->comment('使用门槛');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->integer('use_type')->comment('使用类型：0->全场通用；1->指定分类；2->指定商品');
            $table->string('note', 200)->comment('备注');
            $table->integer('publish_count')->comment('发现数量');
            $table->integer('use_count')->comment('已使用数量');
            $table->integer('receive_count')->comment('领取数量');
            $table->timestamp('enable_time')->comment('可以领取的日期');
            $table->string('code', 64)->comment('优惠码');
            $table->integer('member_level')->comment('可领取的会员类型：0->无限时');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_coupon');
    }
}
