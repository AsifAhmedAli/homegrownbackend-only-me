<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartKitProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_kit_products', function (Blueprint $table) {
            $table->id();
            $table->string('cart_id');
            $table->string('kit_id');
            $table->string('product_id')->nullable();
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('price', 18, 2)->default(0);
            $table->string('quantity')->nullable();
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
        Schema::dropIfExists('cart_kit_products');
    }
}
