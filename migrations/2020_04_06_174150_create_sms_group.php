<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsGroup extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('goods_id')->comment('团购商品id');
            $table->string('goods_name', 127)->comment('团购商品名称');
            $table->decimal('origin_price', 10,2)->default(0.00)->comment('商品价格');
            $table->decimal('group_price', 10,2)->default(0.00)->comment('拼团价格');
            $table->timestamp('start_time')->comment('开始时间');
            $table->timestamp('end_time')->comment('结束时间');
            $table->integer('hours')->default(0)->comment('拼团小时');
            $table->integer('peoples')->default(0)->comment('成团人数');
            $table->integer('status')->default(0)->comment('状态');
            $table->integer('max_people')->default(0)->comment('拼团总人数');
            $table->string('parent_category_name', 64)->nullable(false)->comment('父分类名称');
            $table->timestamps();

            $table->index('goods_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_group');
    }
}
