<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateGxHomePageTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('gx_home_page', function (Blueprint $table) {
        $table->id();
        
        /*section 1*/
        
        $table->string('name');
        $table->string('banner_title');
        $table->text('banner_short_description');
        $table->string('banner_feature_1_title');
        $table->string('banner_feature_2_title');
        $table->string('banner_feature_3_title');
        $table->string('banner_video_thumbnail_image');
        $table->string('banner_video_url')->nullable();
        
        $table->string('banner_cta_1_title')->nullable();
        $table->string('banner_cta_1_url', 300)->nullable();
        $table->string('banner_cta_2_title')->nullable();
        $table->string('banner_cta_2_url',300)->nullable();
        
        
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
        
        /*section 3 packages*/
        $table->string('package_1_name');
        $table->string('package_1_title');
        $table->string('package_1_short_title');
        $table->string('package_1_image');
        $table->text('package_1_description')->nullable();
        $table->string('package_1_cta_1_title')->nullable();
        $table->string('package_1_cta_1_url',300)->nullable();
        $table->string('package_1_cta_2_title')->nullable();
        $table->string('package_1_cta_2_url',300)->nullable();
        
        $table->string('package_2_name');
        $table->string('package_2_title');
        $table->string('package_2_short_title');
        $table->string('package_2_image');
        $table->text('package_2_description')->nullable();
        $table->string('package_2_cta_1_title')->nullable();
        $table->string('package_2_cta_1_url',300)->nullable();
        $table->string('package_2_cta_2_title')->nullable();
        $table->string('package_2_cta_2_url',300)->nullable();
        
        
        $table->string('package_3_name');
        $table->string('package_3_title');
        $table->string('package_3_short_title');
        $table->string('package_3_image');
        $table->text('package_3_description')->nullable();
        $table->string('package_3_cta_1_title')->nullable();
        $table->string('package_3_cta_1_url',300)->nullable();
        $table->string('package_3_cta_2_title')->nullable();
        $table->string('package_3_cta_2_url',300)->nullable();
        
        /*section 4 subscription */
        $table->string('subscription_title');
        $table->text('subscription_description');
        $table->string('subscription_cta_1_title')->nullable();
        $table->string('subscription_cta_1_url',300)->nullable();
        $table->string('subscription_cta_2_title')->nullable();
        $table->string('subscription_cta_2_url',300)->nullable();
        $table->string('subscription_step_1_image');
        $table->text('subscription_step_1_description');
        $table->string('subscription_step_2_image');
        $table->text('subscription_step_2_description');
        $table->string('subscription_step_3_image');
        $table->text('subscription_step_3_description');
        
        /*section 5 video section 1*/
        $table->string('video_section_1_title');
        $table->string('video_section_1_image');
        $table->text('video_section_1_description');
        $table->string('video_section_1_cta_title')->nullable();
        $table->string('video_section_1_cta_url',300)->nullable();
        
        $table->string('video_section_2_title');
        $table->string('video_section_2_image');
        $table->string('video_section_2_cta_title')->nullable();
        $table->string('video_section_2_cta_url',300)->nullable();
        $table->text('video_section_2_description');
        
        /*section 6 instagram section */
        $table->string('instagram_section_title')->nullable();
        $table->text('instagram_section_description')->nullable();
        $table->text('instagram_section_buttom_description')->nullable();
        
        /*section 7 book section */
        $table->string('book_title');
        $table->string('book_image')->nullable();
        $table->string('download_book_title')->nullable();
        $table->string('upload_book')->nullable();
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
      Schema::dropIfExists('gx_home_page');
    }
  }
