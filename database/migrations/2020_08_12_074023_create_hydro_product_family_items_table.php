<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroProductFamilyItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_product_family_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hydro_product_family_id');
            $table->string('sku')->nullable();
            $table->integer('priority')->default(0)->nullable();
            $table->boolean('isDefault')->default(false)->nullable();
            $table->string('unitSize')->nullable();
            $table->timestamps();
  
            $table->foreign('hydro_product_family_id')->references('id')->on('hydro_product_families')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hydro_product_family_items');
    }
}
