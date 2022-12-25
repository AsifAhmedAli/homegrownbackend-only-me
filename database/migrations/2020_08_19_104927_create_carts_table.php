<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('tax', 10,2)->default(0);
            $table->double('shipping_charges', 10,2)->default(0);
            $table->boolean('allow_free_shipping')->default(0);
            $table->double('total_price', 10,2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->unsignedInteger('coupon_id')->nullable();
            $table->double('discount')->default(0);
            /****************************** Contact Info Starts ******************************/
            $table->string('contact_information_first_name')->nullable()->comment('Contact Information');
            $table->string('contact_information_last_name')->nullable()->comment('Contact Information');
            $table->string('contact_information_email')->nullable()->comment('Contact Information');
            $table->string('contact_information_phone')->nullable()->comment('Contact Information');
            /******************************* Contact Info Ends *******************************/
            /*===============================================================================*/
            /****************************** Shipping Info Starts *****************************/
            $table->string('shipping_address_first_name')->nullable()->comment('Shipping Address');
            $table->string('shipping_address_last_name')->nullable()->comment('Shipping Address');
            $table->text('shipping_address_address1')->nullable()->comment('Shipping Address');
            $table->text('shipping_address_address2')->nullable()->comment('Shipping Address');
            $table->string('shipping_address_state')->nullable()->comment('Billing Address');
            $table->string('shipping_address_state_type')->nullable()->comment('Billing Address');
            $table->string('shipping_address_city')->nullable()->comment('Billing Address');
            $table->string('shipping_address_zip')->nullable()->comment('Billing Address');
            $table->string('shipping_address_phone')->nullable()->comment('Billing Address');
            $table->string('shipping_address_email')->nullable()->comment('Billing Address');
            /******************************* Shipping Info Ends ******************************/
            /*===============================================================================*/
            /****************************** Billing Info Starts *****************************/
            $table->boolean('is_different_billing')->default(false);
            $table->string('billing_address_first_name')->nullable()->comment('Billing Address');
            $table->string('billing_address_last_name')->nullable()->comment('Billing Address');
            $table->text('billing_address_address1')->nullable()->comment('Billing Address');
            $table->text('billing_address_address2')->nullable()->comment('Billing Address');
            $table->string('billing_address_state')->nullable()->comment('Billing Address');
            $table->string('billing_address_state_type')->nullable()->comment('Billing Address');
            $table->string('billing_address_city')->nullable()->comment('Billing Address');
            $table->string('billing_address_zip')->nullable()->comment('Billing Address');
            $table->string('billing_address_phone')->nullable()->comment('Billing Address');
            $table->string('billing_address_email')->nullable()->comment('Billing Address');
            /******************************* Billing Info Ends ******************************/
            /*===============================================================================*/
            /******************************* Bank Info Starts *******************************/
            $table->text('payment_nonce')->nullable();
            $table->string('card_holder_name')->nullable()->comment('Payment Information');
            $table->string('expiration_month', 2)->nullable()->comment('Payment Information');
            $table->string('expiration_year')->nullable()->comment('Payment Information');
            $table->string('bin')->nullable()->comment('Payment Information');
            $table->string('card_type')->nullable()->comment('Payment Information');
            $table->string('type')->nullable()->comment('Payment Information');
            $table->string('saved_payment_method_token')->nullable()->comment('Payment Information');
            $table->string('last_four', 4)->nullable()->comment('Payment Information');
            $table->string('last_two', 2)->nullable()->comment('Payment Information');
            $table->text('description')->nullable()->comment('Payment Information');
            $table->string('email')->nullable()->comment('Payment Information');
            $table->string('first_name')->nullable()->comment('Payment Information');
            $table->string('last_name')->nullable()->comment('Payment Information');
            $table->string('payer_id')->nullable()->comment('Payment Information');
            $table->string('country_code')->nullable()->comment('Payment Information');
            /******************************** Bank Info Ends ********************************/
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
