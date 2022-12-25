<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroProductInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_product_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hydro_product_id');
            $table->unsignedBigInteger('product_recid');
            $table->string('siteId')->nullable();
            $table->string('name')->nullable();
            $table->decimal('availPhysicalByWarehouse', 10, 2)->default(0)->nullable();
            $table->decimal('availPhysicalTotal', 10, 2)->default(0)->nullable();
            $table->string('bckpInventLocationId')->nullable();
            $table->decimal('bckpAvailPhysicalByWarehouse', 10, 2)->default(0)->nullable();
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
        Schema::dropIfExists('hydro_product_inventories');
    }
}
