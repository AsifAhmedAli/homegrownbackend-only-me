<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTrackingInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tracking_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('shipment_id')->nullable();
            $table->string('so_number')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('tracking');
            $table->string('carrier_code')->nullable();
            $table->string('carrier_service_code')->nullable();
            $table->string('invent_site_id')->nullable();
            $table->string('tracking_link')->nullable();
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
        Schema::dropIfExists('order_tracking_information');
    }
}
