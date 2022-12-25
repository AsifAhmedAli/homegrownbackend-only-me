<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('paypal_plan_id');
            $table->enum('status', ['new', 'renew', 'expired'])->default('new');
            $table->tinyInteger('paid_status')->default(1)->comment('0=unpaid,1=paid');
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('renewed_from')->nullable();
            $table->timestamps();

            $table->foreign('paypal_plan_id')->references('id')->on('paypal_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
}
