<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePackageColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gx_home_page', function (Blueprint $table) {
          $table->dropColumn('package_1_name');
          $table->dropColumn('package_1_title');
          $table->dropColumn('package_1_short_title');
          $table->dropColumn('package_1_image');
          $table->dropColumn('package_1_description');
          $table->dropColumn('package_1_cta_1_title');
          $table->dropColumn('package_1_cta_1_url');
          $table->dropColumn('package_1_cta_2_title');
          $table->dropColumn('package_1_cta_2_url');
  
          $table->dropColumn('package_2_name');
          $table->dropColumn('package_2_title');
          $table->dropColumn('package_2_short_title');
          $table->dropColumn('package_2_image');
          $table->dropColumn('package_2_description');
          $table->dropColumn('package_2_cta_1_title');
          $table->dropColumn('package_2_cta_1_url');
          $table->dropColumn('package_2_cta_2_title');
          $table->dropColumn('package_2_cta_2_url');
  
  
          $table->dropColumn('package_3_name');
          $table->dropColumn('package_3_title');
          $table->dropColumn('package_3_short_title');
          $table->dropColumn('package_3_image');
          $table->dropColumn('package_3_description');
          $table->dropColumn('package_3_cta_1_title');
          $table->dropColumn('package_3_cta_1_url');
          $table->dropColumn('package_3_cta_2_title');
          $table->dropColumn('package_3_cta_2_url');
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
            //
        });
    }
}
