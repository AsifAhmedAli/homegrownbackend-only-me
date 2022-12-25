<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateHomePagesTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('home_page', function (Blueprint $table) {
        $table->id();
        $table->string('banner_text');
        $table->string('banner_products');
        $table->string('featured_categories');
        $table->string('promotional_banner');
        $table->string('promotional_banner_cta_link');
        $table->string('package_1_title');
        $table->text('package_1_description');
        $table->string('package_1_image');
        $table->float('package_1_price')->default(0);
        
        $table->string('package_2_title');
        $table->text('package_2_description');
        $table->string('package_2_image');
        $table->float('package_2_price')->default(0);
        
        $table->string('package_3_title');
        $table->text('package_3_description');
        $table->string('package_3_image');
        $table->float('package_3_price')->default(0);
        $table->string('package_cta_title');
        $table->string('package_cta_link');
        
        $table->string('how_it_work_title');
        $table->text('how_it_work_description');
        $table->string('how_it_work_cta_title');
        $table->string('how_it_work_cta_link');
        $table->string('how_it_work_left_image');
        $table->string('how_it_work_right_image');
        
        $table->string('team_title');
        $table->string('team_cta_title');
        $table->string('team_cta_link');
  
        
        $table->string('bottom_section_title');
        $table->string('bottom_section_description');
        $table->string('bottom_section_cta_title');
        $table->string('bottom_section_book_title');
        $table->string('bottom_section_download_book');
        $table->string('bottom_section_cta_link');
        $table->string('review_section_title');
        
        
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
      Schema::dropIfExists('home_pages');
    }
  }
