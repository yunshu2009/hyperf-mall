<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsCouponHistory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_coupon_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('coupon_id');
            $table->bigInteger('member_id');
            $table->string('coupon_code', 64);
            $table->string('member_nickname', 64)->comment('领取人昵称');
            $table->tinyInteger('get_type')->comment('获取类型：0->后台赠送；1->主动获取');
            $table->integer('use_status')->comment('使用状态：0->未使用；1->已使用；2->已过期');
            $table->bigInteger('order_id')->comment('订单编号');
            $table->string('order_sn', 100)->comment('订单号码');
            $table->timestamps();
            $table->timestamp('use_time')->comment('使用时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_coupon_history');
    }
}
