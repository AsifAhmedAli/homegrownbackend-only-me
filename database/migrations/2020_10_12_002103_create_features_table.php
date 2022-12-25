<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateFeaturesTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('features', function (Blueprint $table) {
        /*basic*/
        
        $table->bigIncrements('id');
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('short_description');
        $table->string('center_image')->nullable();
        
        /*boxes*/
        $table->string('box_1_image');
        $table->string('box_1_title');
        $table->text('box_1_description');
        
        $table->string('box_2_image');
        $table->string('box_2_title');
        $table->text('box_2_description');
        
        $table->string('box_3_image');
        $table->string('box_3_title');
        $table->text('box_3_description');
        
        $table->tinyInteger('is_active')->default(0);
        $table->string('meta_title')->nullable();
        $table->text('meta_description')->nullable();
        $table->text('meta_keywords')->nullable();
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
      Schema::dropIfExists('features');
    }
  }
