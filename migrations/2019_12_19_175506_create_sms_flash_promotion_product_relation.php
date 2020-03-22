<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsFlashPromotionProductRelation extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_flash_promotion_product_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('flash_promotion_id')->nullable(false);
            $table->bigInteger('flash_promotion_session_id')->nullable(false)->comment('限时购场次');
            $table->bigInteger('product_id')->nullable(false);
            $table->decimal('flash_promotion_price', 10, 2)->nullable(false)->comment('限时购价格');
            $table->integer('flash_promotion_count')->nullable()->comment('限时购数量');
            $table->integer('flash_promotion_limit')->nullable()->comment('每人限购数量');
            $table->integer('sort')->default(0)->comment('排序');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_flash_promotion_product_relation');
    }
}
