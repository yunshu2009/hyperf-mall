<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCmsSubject extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cms_subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->nullable(false);
            $table->string('title', 100)->nullable(false);
            $table->string('pic', 500)->comment('专题主图')->nullable(false);
            $table->integer('product_count')->comment('关联产品数量')->default(0);
            $table->tinyInteger('recommend_status')->comment('显示状态：0->不显示；1->显示');
            $table->integer('collect_count')->comment('收藏数量')->default(0);
            $table->integer('read_count')->comment('阅读数量')->default(0);
            $table->integer('comment_count')->comment('评论数量')->default(0);
            $table->string('album_pics', 1000)->comment('画册图片用逗号分割')->nullable();
            $table->string('description', 1000)->comment('描述')->nullable();
            $table->tinyInteger('show_status')->comment('显示状态：0->不显示；1->显示')->default(1);
            $table->text('content')->nullable(false);
            $table->integer('forward_count')->comment('转发数')->default(0);

            $table->string('category_name', 200)->comment('专题分类名称')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_project');
    }
}
