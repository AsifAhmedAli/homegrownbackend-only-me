<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHowItWorkSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('how_it_work_sections', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('title')->nullable();
          $table->string('image')->nullable();
          $table->text('description');
          $table->tinyInteger('is_active')->default(0);
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
        Schema::dropIfExists('how_it_work_sections');
    }
}
