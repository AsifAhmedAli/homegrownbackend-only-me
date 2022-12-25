<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoreLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gx_about_us', function (Blueprint $table) {
            $table->string('app_store_link')->after('main_title')->nullable();
            $table->string('play_store_link')->after('app_store_link')->nullable();
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
            $table->dropColumn('app_store_link');
            $table->dropColumn('play_store_link');
        });
    }
}
