<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUmsMemberReceiveAddress extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 会员收货地址表
        Schema::create('ums_member_receive_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->index();
            $table->string('name', 100)->nullable(false);
            $table->string('phone_number', 64)->nullable(false);
            $table->tinyInteger('default_status')->default(0)->comment('是否为默认');
            $table->string('post_code', 32)->nullable(true)->comment('邮政编码');
            $table->string('province', 32)->nullable(false)->comment('省份/直辖市');
            $table->string('city', 32)->nullable(false)->comment('省份/直辖市');
            $table->string('region', 32)->nullable(false)->comment('省份/直辖市');
            $table->string('detail_address', 128)->nullable(false)->comment('详细地址(街道)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ums_member_receive_address');
    }
}
