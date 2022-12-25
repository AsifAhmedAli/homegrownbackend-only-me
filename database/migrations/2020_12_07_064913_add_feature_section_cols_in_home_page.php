<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeatureSectionColsInHomePage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->string('featured_section_title')->after('banner_cta_url_2');
            $table->text('featured_section_text')->after('featured_section_title');
            $table->dropColumn('promotional_banner_cta_link', 'promotional_banner');

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
            $table->dropColumn('featured_section_title', 'featured_section_text');
            $table->string('promotional_banner_cta_link', 'promotional_banner');
        });
    }
}
