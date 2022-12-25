<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHowItWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('how_it_work', function (Blueprint $table) {
            $table->id();
            
            /* banner section */
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_left_image')->nullable();
            $table->string('banner_title');
            $table->text('banner_description');
            
            /* steps */
            $table->string('section_1_title');
            $table->text('section_1_description');
            
            $table->string('step_1_image')->nullable();
            $table->string('step_1_title');
            $table->text('step_1_description');
            
            $table->string('step_2_image')->nullable();
            $table->string('step_2_title');
            $table->text('step_2_description');
            
            $table->string('step_3_image')->nullable();
            $table->string('step_3_title');
            $table->text('step_3_description');
            
            /*section 2*/
            $table->string('section_2_description')->nullable();
            $table->string('section_2_image')->nullable();
            $table->string('section_2_cta_title')->nullable();
            $table->string('section_2_cta_link')->nullable();
            
            /*book section */
            $table->string('book_title');
            $table->string('book_image')->nullable();
            $table->string('download_book_title')->nullable();
            $table->string('upload_book')->nullable();
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
        Schema::dropIfExists('how_it_work');
    }
}
