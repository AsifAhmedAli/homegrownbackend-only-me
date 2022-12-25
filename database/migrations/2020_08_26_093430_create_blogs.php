<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateBlogs extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('blogs', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('author');
        $table->string('slug')->nullable();
        $table->text('short_description');
        $table->longText('description')->nullable();
        $table->string('thumbnail_image')->comment('Thumbnail Image for listing');
        $table->string('featured_image')->nullable()->comment('Featured Image for blog detail');
        $table->string('additional_image_1')->nullable()->comment('for blog detail');
        $table->string('additional_image_2')->nullable()->comment('for blog detail');
        
        // SEO
        $table->string('meta_title')->nullable()->comment('SEO Title');
        $table->string('meta_keywords')->nullable()->comment('SEO Meta Keywords');
        $table->string('meta_description')->nullable()->comment('SEO Meta Description');
        $table->date('published_at')->nullable();
        $table->tinyInteger('is_active')->default(0);
        $table->softDeletes();
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
      Schema::dropIfExists('blogs');
    }
  }
