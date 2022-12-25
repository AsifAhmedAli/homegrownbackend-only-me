<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnsNullableInGxHowItWorks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gx_how_it_works', function (Blueprint $table) {
            $table->string('section_2_left_title')->nullable(true)->change();
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
            $table->string('section_2_left_title')->change();
        });
    }
}
