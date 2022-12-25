<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('is_quantity_tracking')->default(false);
            $table->boolean('continue_selling_when_out_of_stock')->default(false);
            $table->integer('quantity')->default(0);
            $table->string('barcode')->nullable()->comment('ISBN, UPC, GTIN, etc.');
            $table->double('price', 10, 2);
            $table->double('sale_price', 10, 2)->nullable();
            $table->double('tax', 10, 2)->nullable();
            $table->double('shipping_charges', 10, 2)->nullable();
            $table->longText('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
