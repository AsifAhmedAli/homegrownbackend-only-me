<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHowItWordIdInAboutUsSection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('how_it_work_sections', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change();
            $table->unsignedBigInteger('how_it_work_page_id')->after('id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('how_it_work_sections', function (Blueprint $table) {
            $table->string('image')->nullable(true)->change();
            $table->dropColumn('how_it_work_page_id');
        });
    }
}
