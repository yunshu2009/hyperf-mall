<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePmsProductAttributeCategory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms_product_attribute_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64);
            $table->integer('attribute_count')->comment('属性数量');
            $table->integer('param_count')->comment('参数数量');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_product_attribute_category');
    }
}
