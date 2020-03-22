<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsHomeBrand extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 首页推荐品牌表
        Schema::create('sms_home_brand', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('brand_id')->nullable(false);
            $table->string('brand_name', 64)->nullable(false);
            $table->tinyInteger('recommend_status')->default(0)->nullable(false);
            $table->integer('sort')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_home_brand');
    }
}
