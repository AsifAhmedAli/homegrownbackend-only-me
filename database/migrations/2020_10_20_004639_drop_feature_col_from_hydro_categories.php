<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFeatureColFromHydroCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hydro_categories', function (Blueprint $table) {
            $table->dropColumn('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hydro_categories', function (Blueprint $table) {
            $table->boolean('is_featured')->after('is_active');
        });
    }
}
