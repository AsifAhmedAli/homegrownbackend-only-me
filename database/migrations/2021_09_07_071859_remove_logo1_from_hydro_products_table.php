<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLogo1FromHydroProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hydro_products', function (Blueprint $table) {
            $table->dropColumn('logo1');
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
            $table->string('logo1')->nullable()->after('logo');
        });
    }
}
