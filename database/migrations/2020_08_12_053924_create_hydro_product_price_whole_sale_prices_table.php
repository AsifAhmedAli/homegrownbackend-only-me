<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroProductPriceWholeSalePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_product_price_whole_sale_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hydro_product_price_id');
            $table->decimal('yourPrice', 10, 2)->nullable();
            $table->decimal('price')->nullable();
            $table->integer('qtyStart')->nullable();
            $table->integer('qtyEnd')->nullable();
            $table->timestamps();
  
            $table->foreign('hydro_product_price_id', 'whole_sale_foreign')->references('id')->on('hydro_product_prices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hydro_product_price_whole_sale_prices');
    }
}
