<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrackingNumberAndKitStatusColsInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('kit_tracking_number')->nullable()->after('tracking_number');
            $table->string('kit_status')->nullable()->after('status')->default(1)->comment('0=pending,1=processing,2=completed,3=cancelled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('kit_tracking_number', 'kit_status');
        });
    }
}
