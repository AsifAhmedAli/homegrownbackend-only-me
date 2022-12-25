<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusInGrowLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_logs', function (Blueprint $table) {
            $table->tinyInteger('status')
                ->comment('0=incomplete,1=complete')
                ->default(0)
                ->after('is_active');
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
            $table->dropColumn('status');
        });
    }
}
