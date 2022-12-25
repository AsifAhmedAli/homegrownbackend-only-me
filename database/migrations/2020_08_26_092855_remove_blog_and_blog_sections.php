<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveBlogAndBlogSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      Schema::dropIfExists('blogs');
      Schema::dropIfExists('blog_sections');
      DB::statement('SET FOREIGN_KEY_CHECKS = 1');
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
