<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_products', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_id');
            $table->string('name')->nullable();
            $table->string('object')->nullable();
            $table->boolean('active')->default(false);
            $table->longText('attributes')->nullable();
            $table->longText('description')->nullable();
            $table->longText('images')->nullable();
            $table->boolean('livemode')->nullable();
            $table->text('statement_descriptor')->nullable();
            $table->string('type')->nullable();
            $table->string('unit_label')->nullable();
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
        Schema::dropIfExists('stripe_products');
    }
}
