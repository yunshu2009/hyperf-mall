<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePmsMemberPrice extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms_member_price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->nullable(false);
            $table->bigInteger('member_level_id')->nullable(false);
            $table->decimal('member_price', 10, 2);
            $table->string('member_level_name', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_member_price');
    }
}
