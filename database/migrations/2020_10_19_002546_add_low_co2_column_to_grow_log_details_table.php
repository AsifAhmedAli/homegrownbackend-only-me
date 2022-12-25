<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLowCo2ColumnToGrowLogDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_log_details', function (Blueprint $table) {
            $table->string('low_co2', 10)->after('co2');
            $table->renameColumn('co2','high_co2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grow_log_details', function (Blueprint $table) {
            $table->renameColumn('high_co2','co2');
            $table->dropColumn('low_co2', 10);
        });
    }
}
