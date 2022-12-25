<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToGxAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gx_about_us', function (Blueprint $table) {
            Schema::table('gx_about_us', function (Blueprint $table) {
                $table->text("banner_image")->after('main_description')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gx_about_us', function (Blueprint $table) {
            $table->dropColumn("banner_image");
        });
    }
}
