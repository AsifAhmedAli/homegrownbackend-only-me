<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShowOnHGXOrGx extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->tinyInteger('show_on_hgp_project')->default(1)->after('answer');
            $table->tinyInteger('show_on_gx_project')->default(1)->after('show_on_hgp_project');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('show_on_hgp_project');
            $table->dropColumn('show_on_gx_project');
        });
    }
}
