<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePmsBrandTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms_brand', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('name', 64)->comment('品牌名');
            $table->string('first_letter', 8)->comment('首字母');
            $table->integer('sort')->comment('排序');
            $table->integer('factory_status')->comment('是否为品牌制造商 0=>不是；1=>是');
            $table->integer('show_status')->comment('显示状态');
            $table->integer('product_count')->comment('产品数量');
            $table->integer('product_comment_count')->comment('产品评论数量');
            $table->string('logo', 255)->comment('品牌logo');
            $table->string('big_pic', 255)->comment('专区大图');
            $table->text('brand_story')->comment('品牌故事');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_brand');
    }
}
