<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hydro_product_id');
            $table->unsignedBigInteger('product_recid');
            $table->string('attribute');
            $table->text('value')->nullable();
            $table->integer('dataType')->nullable()->comment('3 = float, 5 = text, 6 = boolean');
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
        Schema::dropIfExists('hydro_product_attributes');
    }
}
