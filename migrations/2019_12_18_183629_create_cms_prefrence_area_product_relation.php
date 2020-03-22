<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCmsPrefrenceAreaProductRelation extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cms_prefrence_area_product_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('prefrence_area_id')->nullable(false);
            $table->bigInteger('product_id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_prefrence_area_product_relation');
    }
}
