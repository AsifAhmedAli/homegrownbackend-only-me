<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSection3And4InAboutUs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('how_it_work', function (Blueprint $table) {
            $table->string('section_3_image')->after('section_2_image');
            $table->string('section_3_title')->after('section_3_image');
            $table->text('section_3_description')->nullable()->after('section_3_title');
  
            $table->string('section_4_title')->after('section_3_description');
            $table->text('section_4_description')->nullable()->after('section_4_title');
            $table->string('section_4_first_image')->after('section_4_description');
            $table->string('section_4_second_image')->after('section_4_first_image');
            $table->string('section_4_arrow_image')->after('section_4_second_image');
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
            $table->dropColumn('section_3_image');
            $table->dropColumn('section_3_title');
            $table->dropColumn('section_3_description');
            
            $table->dropColumn('section_4_title');
            $table->dropColumn('section_4_description');
            $table->dropColumn('section_4_fist_image');
            $table->dropColumn('section_4_second_image');
            $table->dropColumn('section_4_arrow_image');
        });
    }
}
