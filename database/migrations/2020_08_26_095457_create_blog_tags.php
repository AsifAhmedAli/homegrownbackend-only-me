<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tags', function (Blueprint $table) {
          $table->unsignedBigInteger('blog_id');
          $table->unsignedInteger('tag_id');
  
          $table->primary(['blog_id', 'tag_id']);
          $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
          $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('blog_tags');
    }
}
