<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductIdIfKitProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kit_products', function (Blueprint $table) {
            $table->renameColumn('product_id', 'hydro_product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kit_products', function (Blueprint $table) {
            $table->renameColumn('hydro_product_id', 'product_id');
        });
    }
}
