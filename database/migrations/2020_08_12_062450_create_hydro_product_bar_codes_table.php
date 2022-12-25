<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroProductBarCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_product_bar_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hydro_product_id');
            $table->unsignedBigInteger('product_recid');
            $table->string('barcode')->nullable();
            $table->string('barcodeType')->nullable();
            $table->string('uom')->nullable();
            $table->timestamps();
  
            $table->foreign('hydro_product_id')->references('id')->on('hydro_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hydro_product_bar_codes');
    }
}
