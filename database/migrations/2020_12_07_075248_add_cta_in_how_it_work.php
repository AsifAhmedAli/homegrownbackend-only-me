<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCtaInHowItWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('how_it_work', function (Blueprint $table) {
            $table->string('section_3_cta_text')->nullable()->after('section_3_description');
            $table->string('section_3_cta_url')->nullable()->after('section_3_cta_text');
            $table->string('section_4_cta_text')->nullable()->after('section_4_description');
            $table->string('section_4_cta_url')->nullable()->after('section_4_cta_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('how_it_work', function (Blueprint $table) {
            $table->dropColumn('section_3_cta_text', 'section_3_cta_url', 'section_4_cta_text', 'section_4_cta_url');
        });
    }
}
