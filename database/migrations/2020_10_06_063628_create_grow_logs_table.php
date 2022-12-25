<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrowLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('grow_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('plant_name');
            $table->string('stage', 6)->nullable();
            $table->date('started_at')->nullable();
            $table->integer('expected_days')->default(0);
            $table->string('lighting', 12)->nullable();
            $table->integer('cycle_light')->default(0)->comment('Light Cycle Light Side');
            $table->string('lighting_type')->nullable();
            $table->string('wattage')->nullable();
            $table->string('media_type')->nullable();
            $table->string('strain')->nullable();
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('grow_logs');
    }
}
