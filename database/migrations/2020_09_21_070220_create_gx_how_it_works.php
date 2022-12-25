<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateGxHowItWorks extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('gx_how_it_works', function (Blueprint $table) {
        $table->id();
        /*section 1*/
        $table->string('banner_first_image');
        $table->string('banner_second_image');
        $table->string('banner_title');
        $table->string('banner_description');
        
        /*section 2*/
        $table->string('feature_1_image');
        $table->string('feature_1_title');
        $table->text('feature_1_description');
        
        $table->string('feature_2_image');
        $table->string('feature_2_title');
        $table->text('feature_2_description');
        
        $table->string('feature_3_image');
        $table->string('feature_3_title');
        $table->text('feature_3_description');
        
        
        /*section 3 */
        $table->string('section_1_image');
        $table->string('section_1_title');
        $table->text('section_1_description')->nullable();
        $table->string('section_1_cta_1_title')->nullable();
        $table->string('section_1_cta_1_url', 300)->nullable();
        
        /*section 4 subscription */
        $table->string('subscription_step_1_image');
        $table->text('subscription_step_1_description');
        $table->string('subscription_step_2_image');
        $table->text('subscription_step_2_description');
        $table->string('subscription_step_3_image');
        $table->text('subscription_step_3_description');
        
        
        /*section 5 */
        $table->string('section_2_title');
        $table->string('section_2_left_title');
        $table->text('section_2_left_description');
        $table->string('section_2_right_image');
        $table->string('section_2_cta_1_title')->nullable();
        $table->string('section_2_cta_1_url', 300)->nullable();
        
        /*section 6 instagram section  */
        $table->string('instagram_section_title')->nullable();
        $table->text('instagram_section_description')->nullable();
        $table->text('instagram_section_buttom_description')->nullable();
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
        Schema::dropIfExists('gx_how_it_works');
    }
}
