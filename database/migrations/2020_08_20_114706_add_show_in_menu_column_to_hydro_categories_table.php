<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowInMenuColumnToHydroCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hydro_categories', function (Blueprint $table) {
            $table->boolean('show_in_menu')->default(true)->after('is_root');
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
            $table->dropColumn('show_in_menu');
        });
    }
}
