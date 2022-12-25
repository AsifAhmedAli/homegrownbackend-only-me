<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGrowLogDetailsTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_log_details', function (Blueprint $table) {
            $table->renameColumn('high_wahter_ph','water_ph');
            $table->dropColumn('low_wahter_ph');
            $table->renameColumn('high_water_strength','water_strength');
            $table->dropColumn('low_water_strength');
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
            $table->renameColumn('water_ph','high_wahter_ph');
            $table->string('low_wahter_ph',10);
            $table->renameColumn('water_strength','high_water_strength');
            $table->string('low_water_strength',10);
        });
    }
}
