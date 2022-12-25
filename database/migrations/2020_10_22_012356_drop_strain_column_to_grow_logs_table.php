<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStrainColumnToGrowLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_logs', function (Blueprint $table) {
          $table->dropForeign(['strain_id']);
          $table->dropColumn('strain_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grow_logs', function (Blueprint $table) {
            $table->foreignId('strain_id')->after('media_type_id');
        });
    }
}
