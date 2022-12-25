<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleLogosToHydroProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hydro_products', function (Blueprint $table) {
            $table->string('logo1')->nullable();
            $table->string('logo1_tooltip')->nullable();

            $table->string('logo2')->nullable();
            $table->string('logo2_tooltip')->nullable();

            $table->string('logo3')->nullable();
            $table->string('logo3_tooltip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hydro_products', function (Blueprint $table) {
            $table->dropColumn('logo1', 'logo1_tooltip', 'logo2', 'logo2_tooltip', 'logo3', 'logo3_tooltip');
        });
    }
}
