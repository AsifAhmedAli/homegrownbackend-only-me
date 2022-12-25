<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFieldsNullableInPaypalPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paypal_plans', function (Blueprint $table) {
          $table->integer('frequency_interval')->nullable()->change();
          $table->text('description')->nullable()->change();
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
          $table->integer('frequency_interval')->nullable(false)->change();
          $table->text('description')->nullable(false);
        });
    }
}
