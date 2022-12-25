<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAboutUsImagesFieldsRequire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('how_it_work', function (Blueprint $table) {
          $table->string('banner_image')->nullable(false)->change();
          $table->string('banner_left_image')->nullable(false)->change();
          $table->string('step_1_image')->nullable(false)->change();
          $table->string('step_2_image')->nullable(false)->change();
          $table->string('step_3_image')->nullable(false)->change();
          $table->string('section_2_image')->nullable(false)->change();
          $table->string('book_image')->nullable(false)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('how_it_work', function (Blueprint $table) {
          $table->string('banner_image')->nullable()->change();
          $table->string('banner_left_image')->nullable()->change();
          $table->string('step_1_image')->nullable()->change();
          $table->string('step_2_image')->nullable()->change();
          $table->string('step_3_image')->nullable()->change();
          $table->string('section_2_image')->nullable()->change();
          $table->string('book_image')->nullable()->change();
        });
    }
}
