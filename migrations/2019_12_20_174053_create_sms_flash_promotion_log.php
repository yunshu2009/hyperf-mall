<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsFlashPromotionLog extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 限时购通知记录
        Schema::create('sms_flash_promotion_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->nullable(false);
            $table->bigInteger('product_id')->nullable(false);
            $table->string('member_phone', 64)->nullable();
            $table->string('product_name', 100)->nullable();
            $table->timestamp('subscribe_time')->nullable()->comment('会员订阅时间');
            $table->timestamp('send_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_promotion_log');
    }
}
