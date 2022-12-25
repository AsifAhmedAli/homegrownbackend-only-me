<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrowLogStrainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grow_log_strain', function (Blueprint $table) {
            $table->foreignId('grow_log_id')->constrained()->onDelete('cascade');
            $table->foreignId('strain_id')->constrained()->onDelete('cascade');
            
            $table->unique(['grow_log_id', 'strain_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grow_log_strain');
    }
}
