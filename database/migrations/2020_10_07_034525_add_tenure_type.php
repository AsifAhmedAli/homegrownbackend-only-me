<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenureType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paypal_plans', function (Blueprint $table) {
            $table->string('tenure_type')->after('type')->default('REGULAR');
            $table->string('usage_type')->after('tenure_type')->default('LICENSED');
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
            $table->dropColumn('usage_type');
            $table->dropColumn('tenure_type');
        });
    }
}
