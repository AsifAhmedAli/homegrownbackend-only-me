<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChnageGrowLogDetailsTableMoreColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_log_details', function (Blueprint $table) {
            $table->renameColumn('runoff_liter','runoff');
            $table->renameColumn('runoff_mililiter','runoff_unit');
            $table->renameColumn('runoff_gallon','runoff_water_strength');
            $table->renameColumn('runoff_ec','runoff_water_strength_unit');
            $table->renameColumn('runoff_ppm_500','runoff_ph');
            $table->dropColumn('runoff_ppm_700');
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
            $table->renameColumn('runoff','runoff_liter');
            $table->renameColumn('runoff_unit','runoff_mililiter');
            $table->renameColumn('runoff_water_strength','runoff_gallon');
            $table->renameColumn('runoff_water_strength_unit','runoff_ec');
            $table->renameColumn('runoff_ph','runoff_ppm_500');
            $table->string('runoff_ppm_700',10);
        });
    }
}
