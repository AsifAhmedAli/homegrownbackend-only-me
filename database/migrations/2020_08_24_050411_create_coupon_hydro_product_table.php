<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponHydroProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_hydro_product', function (Blueprint $table) {
          $table->unsignedBigInteger('coupon_id');
          $table->unsignedBigInteger('hydro_product_id');
  
          $table->primary(['coupon_id', 'hydro_product_id'], 'coupon_hydro_product_primary');
  
          $table->foreign('coupon_id')->on('coupons')->references('id')->onDelete('cascade');
          $table->foreign('hydro_product_id')->on('hydro_products')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_hydro_product');
    }
}
