<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePmsProduct extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('brand_id')->nullable(false);
            $table->bigInteger('product_category_id')->nullable(false);
            $table->bigInteger('feight_template_id')->nullable(false);
            $table->bigInteger('product_attribute_category_id')->nullable();
            $table->string('name', 64)->nullable(false);
            $table->string('pic', 255)->nullable();
            $table->string('product_sn', 64)->nullable()->comment('货号');
            $table->tinyInteger('delete_status')->default(1)->comment('删除状态：0->未删除；1->已删除');
            $table->tinyInteger('publish_status')->default(1)->comment('上架状态：0->下架；1->上架');
            $table->tinyInteger('new_status')->default(0)->comment('新品状态:0->不是新品；1->新品');
            $table->tinyInteger('recommand_status')->default(0)->comment('推荐状态；0->不推荐；1->推荐');
            $table->tinyInteger('verify_status')->default(0)->comment('审核状态：0->未审核；1->审核通过');
            $table->integer('sort')->default(999)->comment('排序');
            $table->integer('sale')->default(0)->comment('销量');
            $table->decimal('price', 10, 2)->nullable(false);
            $table->decimal('promotion_price', 10, 2)->nullable();
            $table->integer('gift_growth')->default(0)->comment('赠送的成长值');
            $table->integer('gift_point')->default(0)->comment('赠送的积分');
            $table->integer('use_point_limit')->nullable()->comment('限制使用的积分数');
            $table->string('sub_title', 255)->nullable(true)->comment('标题');
            $table->text('description')->nullable(false)->comment('商品描述');
            $table->decimal('original_price', 10, 2)->nullable()->comment('市场价');
            $table->integer('stock')->nullable()->comment('库存');
            $table->integer('low_stock')->nullable()->comment('库存预警值');
            $table->string('unit', 16)->nullable()->comment('单位');
            $table->decimal('weight', 10, 2)->nullable()->comment('商品重量，默认为克');
            $table->tinyInteger('preview_status')->nullable()->comment('是否为预告商品：0->不是；1->是');
            $table->string('service_ids', 64)->nullable()->comment('以逗号分割的产品服务：1->无忧退货；2->快速退款；3->免费包邮');
            $table->string('keywords', 255)->nullable();
            $table->string('note', 255)->nullable();
            $table->string('album_pics', 255)->nullable()->comment('画册图片，连产品图片限制为5张，以逗号分割');
            $table->string('detail_title', 255)->nullable();
            $table->text('detail_desc');
            $table->text('detail_html')->comment('产品详情网页内容');
            $table->text('detail_mobile_html')->comment('移动端网页详情');
            $table->timestamp('promotion_start_time')->nullable()->comment('促销开始时间');
            $table->timestamp('promotion_end_time')->nullable()->comment('促销结束时间');
            $table->integer('promotion_per_limit')->nullable()->comment('活动限购数量');
            $table->tinyInteger('promotion_type')->nullable()->comment('促销类型：0->没有促销使用原价;1->使用促销价；2->使用会员价；3->使用阶梯价格；4->使用满减价格；5->限时购');
            $table->string('brand_name', 255)->comment('品牌名称');
            $table->string('product_category_name', 255)->comment('商品分类名称');
            $table->timestamps();

            $table->index('product_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_product');
    }
}
