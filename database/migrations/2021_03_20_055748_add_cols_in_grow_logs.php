<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsInGrowLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_logs', function (Blueprint $table) {
            $table->string('tent_size')->nullable();
            $table->string('nutrients')->nullable();
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
            $table->dropColumn('tent_size', 'nutrients');
        });
    }
}
