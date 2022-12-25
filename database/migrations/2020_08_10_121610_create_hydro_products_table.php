<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recid')->comment('Unique product numeric ID');
            $table->string('sku')->nullable()->comment('Unique product alpha-numeric ID');
            $table->string('name')->nullable()->comment('Product name');
            $table->string('namealias')->nullable();
            $table->unsignedBigInteger('hydro_category_id')->nullable()->comment('Local Auto Incremented Primary key from table hydro_categories');
            $table->unsignedBigInteger('categoryid')->nullable()->comment('Numeric ID for the category to which this product belongs');
            $table->unsignedInteger('sortpriority')->nullable()->comment('Numeric value denoting product sort order within its category ');
            $table->text('description')->nullable()->comment('Product short description');
            $table->longText('webdescription')->nullable()->comment('Product description (HTML formatting included)');
            $table->string('unitsize')->nullable()->comment('Describes the products sellable unit size');
            $table->string('model')->nullable()->comment('Product’s Item Model Group (item type)');
            $table->boolean('isdefault')->default(false)->comment('Denotes product as head of family or not');
            $table->boolean('isdiscontinued')->default(false)->comment('Denotes whether the product has been discontinued. Note that discontinued products can be purchased if there is still inventory available. Discontinued products will never receive more inventory.');
            $table->boolean('isspecialorder')->default(false)->comment('Denotes whether the item is a special order item. Special order items may require greater ship times.');
            $table->boolean('isbuildtoorder')->default(false)->comment('Denotes whether the item is a "Build to Order" item. BTO items typically do not stock inventory but are built on demand.');
            $table->boolean('isclearance')->default(false)->comment('Denotes whether the item is currently on clearance');
            $table->boolean('issale')->default(false)->comment('Denotes whether the item is currently on sale');
            $table->boolean('ishazmat')->default(false)->comment('Denotes whether the item is classified as hazmat');
            $table->string('defaultuom')->nullable()->comment('Denotes this item’s default unit of measure');
            $table->unsignedBigInteger('defaultuomrecid')->nullable()->comment('Numeric ID for this item’s default unit of measure');
            $table->unsignedBigInteger('defaultimageid')->nullable()->comment('ID of this item’s default image');
            $table->string('mixmatchgrp')->nullable()->comment('Denotes the mix/match discount group that this product belongs to. Items in the same group will be discounted based on total volume');
            $table->string('warranty')->nullable()->comment('Describes the warranty length for this item');
            $table->string('trackingdimensiongroup')->nullable()->comment('Tracking Dimension Group');
            $table->dateTimeTz('launchdate')->nullable()->comment('Marks the launch date');
            $table->dateTimeTz('salestartdate')->nullable()->comment('Marks the sale start date');
            $table->dateTimeTz('saleenddate')->nullable()->comment('Marks the sale end date');
            $table->dateTimeTz('modifiedon')->nullable()->comment('Date this product record was last updated');
            $table->dateTimeTz('createdon')->nullable()->comment('Date this product record was create');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('hydro_category_id')->references('id')->on('hydro_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hydro_products');
    }
}
