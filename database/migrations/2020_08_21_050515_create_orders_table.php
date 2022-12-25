<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_first_name')->nullable();
            $table->string('customer_last_name')->nullable();
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_address_1')->nullable();
            $table->string('billing_address_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_address_1')->nullable();
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->string('shipping_country')->nullable();
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->integer('coupon_id')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('currency_rate', 10, 2)->nullable();
            $table->string('locale')->nullable();
            $table->string('status')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('tax')->nullable();
            $table->text('note')->nullable();
            $table->string('shipping_charges')->nullable();
            $table->string('allow_free_shipping')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('contact_information_first_name')->nullable();
            $table->string('contact_information_last_name')->nullable();
            $table->string('contact_information_email')->nullable();
            $table->string('contact_information_phone')->nullable();
            $table->string('is_different_billing')->nullable();
            $table->string('billing_address_company')->nullable();
            $table->string('billing_address_country_id')->nullable();
            $table->string('billing_address_state_type')->nullable();
            $table->string('billing_address_phone')->nullable();
            $table->string('billing_address_email')->nullable();
            $table->string('shipping_address_country_id')->nullable();
            $table->string('shipping_address_state_type')->nullable();
            $table->string('shipping_address_phone')->nullable();
            $table->string('shipping_address_email')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('expiration_month')->nullable();
            $table->string('expiration_year')->nullable();
            $table->string('bin')->nullable();
            $table->string('card_type')->nullable();
            $table->string('type')->nullable();
            $table->string('saved_payment_method_token')->nullable();
            $table->string('last_four')->nullable();
            $table->string('last_two')->nullable();
            $table->string('description')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('country_code')->nullable();
            $table->string('order_number')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
