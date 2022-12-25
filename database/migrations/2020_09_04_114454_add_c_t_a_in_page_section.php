<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCTAInPageSection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_sections', function (Blueprint $table) {
          $table->string('cta_title')->nullable()->after('description');
          $table->string('cta_link')->nullable()->after('cta_title');
          $table->longText('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_sections', function (Blueprint $table) {
          $table->dropColumn('cta_title');
          $table->dropColumn('cta_link');
        });
    }
}
