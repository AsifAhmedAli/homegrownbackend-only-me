<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserKits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_kits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kit_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('kit_name');
            $table->text('kit_description')->nullable();
            $table->float('kit_price');
            $table->text('kit_features')->nullable();
            $table->string('kit_size')->nullable();
            $table->string('billing_street_address');
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_zip_code');
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->boolean('is_different_billing')->default(false);
            $table->string('shipping_street_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip_code')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->tinyInteger('status')->comment('0=processing,2=shipped,3=completed')->default(0);
            $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('user_kits');
    }
}
