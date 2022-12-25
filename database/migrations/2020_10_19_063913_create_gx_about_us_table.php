<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGxAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gx_about_us', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("main_title");
            $table->text("main_description");
            $table->text("main_image");
            $table->text("section_1_title");
            $table->text("section_1_description");
            $table->string("section_1_image");
            $table->text("section_2_title");
            $table->text("section_2_description");
            $table->string("section_2_image");
            $table->text("section_3_title");
            $table->text("section_3_description");
            $table->string("section_3_image");
            $table->text("section_4_title");
            $table->text("section_4_description");
            $table->string("section_4_image");
            $table->text("section_5_title");
            $table->text("section_5_description");
            $table->string("section_5_image");
            $table->text("section_6_title");
            $table->text("section_6_description");
            $table->string("section_6_image");
            $table->string("section_7_image");
            $table->tinyInteger("is_active")->default(0);
            $table->string("meta_title")->nullable();
            $table->text("meta_description")->nullable();
            $table->text("meta_keywords")->nullable();
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
        Schema::dropIfExists('gx_about_us');
    }
}
