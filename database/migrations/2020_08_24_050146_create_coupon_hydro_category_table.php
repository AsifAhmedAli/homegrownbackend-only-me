<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponHydroCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_hydro_category', function (Blueprint $table) {
          $table->unsignedBigInteger('coupon_id');
          $table->unsignedBigInteger('hydro_category_id');
  
          $table->primary(['coupon_id', 'hydro_category_id'], 'coupon_hydro_category_primary');
  
          $table->foreign('coupon_id')->on('coupons')->references('id')->onDelete('cascade');
          $table->foreign('hydro_category_id')->on('hydro_categories')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_hydro_category');
    }
}
