<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePmsSkuStock extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms_sku_stock', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->string('sku_code', 64)->comment('sku编码');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->comment('库存');
            $table->integer('low_stock')->comment('预警库存');
            $table->string('sp1', 64);
            $table->string('sp2', 64);
            $table->string('sp3', 64);
            $table->string('props', 255)->comment('销售属性');
            $table->string('pic', 255)->comment('展示图片');
            $table->integer('sale');
            $table->integer('promotion_price')->comment('单品促销价格');
            $table->integer('lock_stock')->comment('锁定库存');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_sku_stock');
    }
}
