<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_tokens', function (Blueprint $table) {
          $table->id();
          $table->string('type')->default('plan');
          $table->string('env');
          $table->text('access_token');
          $table->string('expires_in')->default(32400);
          $table->string('token_type')->default('Bearer');
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
        Schema::dropIfExists('paypal_tokens');
    }
}
