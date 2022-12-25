<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrowLogDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grow_log_details', function (Blueprint $table) {
            $table->id();
            $table->integer('log_id');
            $table->string('image', 100);
            $table->integer('high_temprature');
            $table->integer('low_temprature');
            $table->string('temprature_unit', 6);
            $table->string('high_humidity', 10);
            $table->string('low_humidity', 10);
            $table->string('co2', 100);
            $table->string('high_water_volume', 10);
            $table->string('low_water_volume', 10);
            $table->string('high_wahter_ph', 10);
            $table->string('low_wahter_ph', 10);
            $table->string('high_water_strength', 10);
            $table->string('low_water_strength', 10);
            $table->string('water_temprature',10);
            $table->string('runoff_liter', 10);
            $table->string('runoff_mililiter', 10);
            $table->string('runoff_gallon', 10);
            $table->string('runoff_ec', 10);
            $table->string('runoff_ppm_500', 10);
            $table->string('runoff_ppm_700', 10);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grow_log_details');
    }
}
