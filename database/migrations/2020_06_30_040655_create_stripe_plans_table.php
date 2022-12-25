<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stripe_product_id');
            $table->string('stripe_id');
            $table->string('object')->nullable();
            $table->boolean('active')->default(false);
            $table->string('aggregate_usage')->nullable();
            $table->double('amount', 10, 2)->default(0);
            $table->string('amount_decimal')->nullable();
            $table->string('billing_scheme')->nullable();
            $table->string('currency')->nullable();
            $table->string('interval')->nullable();
            $table->integer('interval_count')->nullable();
            $table->boolean('livemode')->default(false);
            $table->string('nickname')->nullable();
            $table->string('product')->nullable();
            $table->string('usage_type')->nullable();
            $table->integer('trial_period_days')->nullable();
            $table->timestamps();
            
            $table->foreign('stripe_product_id')->references('id')->on('stripe_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_plans');
    }
}
