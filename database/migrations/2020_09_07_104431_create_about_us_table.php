<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateAboutUsTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('about_us', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        
        /*section 1*/
        $table->text('section_1_title');
        $table->longText('section_1_description');
        $table->string('section_1_image')->nullable();
        $table->string('section_1_cta_title')->nullable();
        $table->string('section_1_cta_link')->nullable();
        
        /*section 2*/
        $table->string('section_2_image')->nullable();
        $table->text('section_2_title');
        $table->longText('section_2_description');
        
        /*section 3*/
        $table->text('section_3_title');
        $table->longText('section_3_description');
        $table->string('section_3_image')->nullable();
        $table->string('distribution_heading')->nullable();
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
      Schema::dropIfExists('about_us');
    }
  }
