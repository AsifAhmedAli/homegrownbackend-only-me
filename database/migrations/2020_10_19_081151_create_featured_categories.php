<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturedCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hydro_category_id');
            $table->text('banner_image');
            $table->text('promotional_banner_image');
            $table->text('promotional_banner_image_url')->nullable();
            $table->timestamps();

            $table->foreign('hydro_category_id')->references('id')->on('hydro_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featured_categories');
    }
}
