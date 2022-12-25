<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_coupon', function (Blueprint $table) {
          $table->unsignedBigInteger('category_id');
          $table->unsignedBigInteger('coupon_id');
  
          $table->primary(['category_id', 'coupon_id'], 'category_coupon_primary');
  
          $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
          $table->foreign('coupon_id')->on('coupons')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_coupon');
    }
}
