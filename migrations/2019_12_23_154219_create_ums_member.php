<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUmsMember extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ums_member', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_level_id')->nullable(false);
            $table->string('username', 64)->nullable(false);
            $table->string('password', 64)->nullable(false);
            $table->string('nickname', 64)->nullable();
            $table->string('phone', 64)->nullable();
            $table->integer('status')->default(1)->comment('帐号启用状态:0->禁用；1->启用');
            $table->string('icon', 500)->comment('像');
            $table->integer('gender')->comment('性别：0->未知；1->男；2->女');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('city', 64)->comment('所做城市');
            $table->string('job', 100)->comment('职业');
            $table->string('personalized_signature', 200)->comment('个性签名');
            $table->tinyInteger('source_type')->comment('用户来源');
            $table->integer('integration')->comment('积分');
            $table->integer('growth')->comment('成长值');
            $table->integer('luckey_count')->comment('剩余抽奖次数');
            $table->integer('history_integration')->default(0)->comment('历史积分数量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ums_member');
    }
}
