<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id');
            $table->text('name');
            $table->string('merchant_id')->nullable();
            $table->string('billing_day_of_month')->nullable();
            $table->integer('billing_frequency')->nullable();
            $table->string('currency_iso_code')->nullable();
            $table->text('description')->nullable();
            $table->longText('web_description')->nullable();
            $table->string('number_of_billing_cycles')->nullable();
            $table->double('price', 10, 2)->default(0);
            $table->string('trial_duration')->nullable();
            $table->string('trial_duration_unit')->nullable();
            $table->string('trial_period')->nullable();
            $table->timestamp('created_date')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
