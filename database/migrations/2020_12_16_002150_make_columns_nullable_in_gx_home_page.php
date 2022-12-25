<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnsNullableInGxHomePage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gx_home_page', function (Blueprint $table) {
            $table->string('banner_feature_1_title')->nullable(true)->change();
            $table->string('banner_feature_2_title')->nullable(true)->change();
            $table->string('banner_feature_3_title')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gx_home_page', function (Blueprint $table) {
            $table->string('banner_feature_1_title')->nullable()->change();
            $table->string('banner_feature_2_title')->nullable()->change();
            $table->string('banner_feature_3_title')->nullable()->change();
        });
    }
}
