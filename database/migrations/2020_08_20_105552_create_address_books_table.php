<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname');
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('email');
            $table->string('street', 191);
            $table->string('country', 100);
            $table->string('city', 191);
            $table->string('state', 191);
            $table->string('phone_no', 30);
            $table->string('postal_code', 9);
            $table->tinyInteger('is_same_shipping')->nullable()->default('1');
            $table->tinyInteger('default')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->boolean('default_billing')->default(0);
            $table->boolean('default_shipping')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('address_books');
    }
}
