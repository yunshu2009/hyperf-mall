<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsHomeAdvertise extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 首页轮播广告表
        Schema::create('sms_home_advertise', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->integer('type')->comment('轮播位置：0->PC首页轮播；1->app首页轮播');
            $table->string('pic', 500);
            $table->timestamp('start_time')->nullable(true);
            $table->timestamp('end_time')->nullable(true);
            $table->integer('status')->default(1)->comment('上下线状态：0->下线；1->上线');
            $table->integer('click_count')->default(0)->comment('点击数');
            $table->integer('order_count')->default(0)->comment('下单数');
            $table->string('url', 500)->nullable()->comment('链接地址');
            $table->string('note', 500)->nullable()->comment('备注');
            $table->integer('sort')->default(0)->comment('排序');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_home_advertise');
    }
}
