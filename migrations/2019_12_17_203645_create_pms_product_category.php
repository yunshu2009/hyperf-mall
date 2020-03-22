<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePmsProductCategory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms_product_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->default(0)->comment('上机分类的编号：0表示一级分类');
            $table->string('name', 64)->nullable(false);
            $table->integer('level')->nullable(false)->comment('分类级别：0->1级；1->2级');
            $table->integer('product_count')->default(0);
            $table->string('product_unit', 64)->nullable();
            $table->tinyInteger('nav_status')->default(0)->comment('是否显示在导航栏：0->不显示；1->显示');
            $table->tinyInteger('show_status')->default(0)->comment('显示状态：0->不显示；1->显示');
            $table->integer('sort')->default(0);
            $table->string('icon', 255)->nullable()->comment('图标');
            $table->string('keywords', 255)->nullable();
            $table->text('description')->comment('描述');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_product_category');
    }
}
