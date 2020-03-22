<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsFlashPromotionSession extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_flash_promotion_session', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('编号');
            $table->string('name', 200)->comment('场次名称');
            $table->time('start_time')->comment('每日开始时间');
            $table->time('end_time')->comment('每日结束时间');
            $table->tinyInteger('status')->default(1)->comment('启用状态：0->不启用；1->启用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_flash_promotion_session');
    }
}
