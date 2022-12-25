<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedToColumnToGrowLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_to')->nullable()->after('user_id');
            
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('SET NULL');
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
            $table->dropForeign('assigned_to');
            $table->dropColumn('assigned_to');
        });
    }
}
