<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
          $table->tinyInteger('show_on_hgp_project')->default(1)->after('description');
          $table->tinyInteger('show_on_gx_project')->default(1)->after('show_on_hgp_project');
          $table->tinyInteger('is_active')->default(1)->after('show_on_gx_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('show_on_hgp_project');
            $table->dropColumn('show_on_gx_project');
            $table->dropColumn('is_active');
        });
    }
}
