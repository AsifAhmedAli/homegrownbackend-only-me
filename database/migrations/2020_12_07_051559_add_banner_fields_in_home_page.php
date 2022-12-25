<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerFieldsInHomePage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->string('banner_title')->after('id');
            $table->string('banner_cta_text_1')->after('banner_text');
            $table->string('banner_cta_url_1')->after('banner_cta_text_1');
            $table->string('banner_cta_text_2')->after('banner_cta_url_1');
            $table->string('banner_cta_url_2')->after('banner_cta_text_2');
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
            $table->dropColumn('banner_title', 'banner_cta_text_1', 'banner_cta_url_1', 'banner_cta_text_2', 'banner_cta_url_2');
        });
    }
}
