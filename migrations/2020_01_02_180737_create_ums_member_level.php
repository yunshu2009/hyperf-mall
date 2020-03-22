<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUmsMemberLevel extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ums_member_level', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->integer('growth_point')->nullable();
            $table->tinyInteger('default_status')->comment('是否为默认等级');
            $table->integer('comment_growth_point')->nullable()->comment('每次评价获取的成长值');
            $table->integer('free_freight_point')->nullable()->comment('免运费标准');
            $table->integer('priviledge_free_freight')->comment('是否有免邮特权');
            $table->integer('priviledge_sign_in')->nullable()->comment('每次有签到特权');
            $table->integer('priviledge_comment')->nullable()->comment('是否有评论奖励特权');
            $table->integer('priviledge_promotion')->nullable()->comment('是否有专项活动特权');
            $table->integer('priviledge_member_price')->nullable()->comment('是否有会员价格特权');
            $table->integer('priviledge_birthday')->nullable()->comment('是否有生日特权');
            $table->string('note', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ums_member_level');
    }
}
