<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGrowLogDetailsTableFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_log_details', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->integer('high_temprature')->nullable()->change();
            $table->integer('low_temprature')->nullable()->change();
            $table->string('temprature_unit')->nullable()->change();
            $table->string('high_humidity')->nullable()->change();
            $table->string('low_humidity')->nullable()->change();
            $table->string('high_co2')->nullable()->change();
            $table->string('low_co2')->nullable()->change();
            $table->string('high_water_volume')->nullable()->change();
            $table->string('low_water_volume')->nullable()->change();
            $table->string('water_ph')->nullable()->change();
            $table->string('water_strength')->nullable()->change();
            $table->string('water_temprature')->nullable()->change();
            $table->string('runoff')->nullable()->change();
            $table->string('runoff_unit')->nullable()->change();
            $table->string('runoff_water_strength')->nullable()->change();
            $table->string('runoff_water_strength_unit')->nullable()->change();
            $table->string('runoff_ph')->nullable()->change();
            $table->text('note')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
