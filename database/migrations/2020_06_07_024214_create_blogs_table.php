<?php
  
  use Carbon\Carbon;
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateBlogsTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('blogs', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('author_id');
        $table->string('title')->reqoi;
        $table->string('slug')->unique();
        $table->string('thumbnail_image')->nullable();
        $table->string('alt_text_for_thumbnail')->nullable()->comment('alt text for thumbnail image'
        );
        $table->string('banner')->nullable();
        $table->string('alt_text_for_banner')->nullable()->comment('alt text for feature image');
        $table->text('short_description')->nullable();
        $table->text('description')->nullable();
        $table->string('attachment_title')->nullable();
        $table->string('attachment')->nullable();
        $table->text('talk_to_team_text')->nullable();
        $table->string('talk_to_team_url')->nullable();
        $table->tinyInteger('infographic')->default(0)->comment('1 = show infographic section, 0 = hide infographic section');
        $table->bigInteger('category_id')->unsigned()->nullable();
        $table->string('seo_title')->nullable();
        $table->text('meta_description')->nullable();
        $table->text('meta_keywords')->nullable();
        $table->tinyInteger('status')->default(1)->comment('1 = active, 0 = inactive');
        $table->tinyInteger('show_section_counter')->default(1);
        $table->tinyInteger('show_background_black_circle')->default(1);
        $table->date('publish_date')->default(Carbon::now());
        $table->timestamps();
        $table->softDeletes();
        $table->foreign('category_id')->references('id')->on('categories')->onDelete("set null");
        $table->foreign('author_id')->references('id')->on('authors');
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
