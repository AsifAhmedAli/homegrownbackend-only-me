<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('blog_sections', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('blog_id')->unsigned()->nullable();
        $table->string('title');
        $table->string('image')->nullable();
        $table->string('alt_text_for_section_image')->nullable()->comment('alt text for section image');
        $table->string('source_text')->nullable();
        $table->string('source_cta_url')->nullable();
        $table->string('attachment')->nullable()->comment('post attachment like pdf');
        $table->text('description');
        $table->timestamps();
        $table->softDeletes();
    
        // set null of post deleted
        $table->foreign('blog_id')->references('id')->on('blogs')->onDelete("set null");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_sections');
    }
}
