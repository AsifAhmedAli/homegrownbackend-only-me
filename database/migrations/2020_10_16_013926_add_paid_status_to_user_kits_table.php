<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidStatusToUserKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_kits', function (Blueprint $table) {
            $table->tinyInteger('paid_status')->after("kit_name")->default('0')->comment('0=unpaid,1=paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_kits', function (Blueprint $table) {
            $table->dropColumn('paid_status');
        });
    }
}
