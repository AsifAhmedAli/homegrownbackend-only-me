<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestimonialFieldsIntoHomepageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->text('testimonial_description')->after('featured_products_title')->nullable();
            $table->string('testimonial_title')->after('featured_products_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->dropColumn('testimonial_title');
            $table->dropColumn('testimonial_description');
        });
    }
}
