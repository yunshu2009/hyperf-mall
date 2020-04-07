<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSmsGroupMember extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_group_member', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_id')->comment('团购id');
            $table->bigInteger('member_id')->comment('参与人id');
            $table->bigInteger('main_id')->comment('发起人id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_group_member');
    }
}
