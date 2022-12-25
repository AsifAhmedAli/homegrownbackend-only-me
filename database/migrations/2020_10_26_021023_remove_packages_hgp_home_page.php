<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePackagesHgpHomePage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_page', function (Blueprint $table) {
          $table->dropColumn('package_1_title');
          $table->dropColumn('package_1_description');
          $table->dropColumn('package_1_image');
          $table->dropColumn('package_1_price');
  
          $table->dropColumn('package_2_title');
          $table->dropColumn('package_2_description');
          $table->dropColumn('package_2_image');
          $table->dropColumn('package_2_price');
  
          $table->dropColumn('package_3_title');
          $table->dropColumn('package_3_description');
          $table->dropColumn('package_3_image');
          $table->dropColumn('package_3_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page', function (Blueprint $table) {
        
        });
    }
}
