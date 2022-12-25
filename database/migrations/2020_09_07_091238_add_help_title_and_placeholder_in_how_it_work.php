<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHelpTitleAndPlaceholderInHowItWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('how_it_work', function (Blueprint $table) {
          $table->string('help_section_title')->nullable()->after('section_2_cta_link');
          $table->string('help_section_placeholder')->after('help_section_title')->nullable();
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
          $table->dropColumn('help_section_title');
          $table->dropColumn('help_section_placeholder');
        });
    }
}
