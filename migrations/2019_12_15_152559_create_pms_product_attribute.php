<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePmsProductAttribute extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms_product_attribute', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_attribute_category_id');
            $table->string('name', 64);
            $table->integer('select_type')->comment('属性选择类型：0->唯一；1->单选；2->多选');
            $table->integer('input_type')->comment('属性录入方式：0->手工录入；1->从列表中选取');
            $table->string('input_list', 255)->comment('可选值列表，以逗号隔开');
            $table->integer('sort')->comment('排序字段：最高的可以单独上传图片');
            $table->integer('filter_type')->comment('分类筛选样式：1->普通；1->颜色');
            $table->integer('search_type')->comment('检索类型；0->不需要进行检索；1->关键字检索；2->范围检索');
            $table->integer('related_status')->comment('相同属性产品是否关联；0->不关联；1->关联');
            $table->integer('hand_add_status')->comment('是否支持手动新增；0->不支持；1->支持');
            $table->integer('type')->comment('属性的类型；0->规格；1->参数');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_product_attribute');
    }
}
