<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameGrowLogFeedbackColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_log_feedback', function(Blueprint $table) {
            $table->dropForeign(['grow_log_id']);
            $table->dropColumn('grow_log_id');
            $table->foreignId('grow_log_detail_id')->after("id")->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grow_log_feedback', function(Blueprint $table) {
            //
        });
    }
}
