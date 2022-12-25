<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissedCycle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paypal_plans', function (Blueprint $table) {
            $table->integer('missed_cycles')->default(3)->after('total_cycles')->comment('How many missed billing cycles before a subscription is paused');
            $table->tinyInteger('auto_bill_outstanding')->default(1)->after('missed_cycles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paypal_plans', function (Blueprint $table) {
            $table->dropColumn('missed_cycles');
            $table->dropColumn('auto_bill_outstanding');
        });
    }
}
