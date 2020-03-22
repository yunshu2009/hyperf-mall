<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateOmsCartItem extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('oms_cart_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->nullable(false);
            $table->bigInteger('product_sku_id')->nullable(false);
            $table->bigInteger('member_id')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->decimal('price', 10, 2);
            $table->string('sp1', 200);
            $table->string('sp2', 200);
            $table->string('sp3', 200);

            $table->string('product_pic', 1000);
            $table->string('product_name', 500);
            $table->string('product_sub_title', 500);
            $table->string('product_sku_code', 200);
            $table->string('member_nickname', 500);

            $table->integer('product_category_id');
            $table->string('product_brand', 200);
            $table->string('product_sn', 200);
            $table->string('product_attr', 500)->comment('商品销售属性:[{"key":"颜色","value":"颜色"},{"key":"容量","value":"4G"}]');

            $table->timestamps();
            $table->timestamp('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oms_cart_item');
    }
}
