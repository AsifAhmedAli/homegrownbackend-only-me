<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBannerCTAColumnsToGxPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gx_pricings', function (Blueprint $table) {
            $table->dropColumn('banner_cta_title', 'banner_cta_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gx_pricings', function (Blueprint $table) {
            $table->string('banner_cta_title')->nullable()->after('banner_description');
            $table->string('banner_cta_url')->nullable()->after('banner_cta_title');
        });
    }
}
