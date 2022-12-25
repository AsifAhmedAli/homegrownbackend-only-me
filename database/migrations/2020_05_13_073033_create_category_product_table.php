<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_product', function (Blueprint $table) {
          $table->unsignedBigInteger('category_id');
          $table->unsignedBigInteger('product_id');
          
          $table->primary(['category_id', 'product_id'], 'category_product_primary');
          
          $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
          $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_product');
    }
}
