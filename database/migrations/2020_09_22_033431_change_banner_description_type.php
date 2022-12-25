<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBannerDescriptionType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gx_how_it_works', function (Blueprint $table) {
            $table->text('banner_description')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gx_how_it_works', function (Blueprint $table) {
          $table->string('banner_description')->change()->nullable(true);
        });
    }
}
