<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class SmsHomeRecommendSubject extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_home_recommend_subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('subject_id')->nullable(false);
            $table->string('subject_name', 64)->nullable(false);
            $table->tinyInteger('recommend_status')->default(1);
            $table->integer('sort')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_home_recommend_subject');
    }
}
