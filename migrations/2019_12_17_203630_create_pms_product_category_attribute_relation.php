<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePmsProductCategoryAttributeRelation extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms_product_category_attribute_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_category_id')->comment('商品分类id');
            $table->bigInteger('product_attribute_id')->comment('商品属性id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_product_category_attribute_relation');
    }
}
