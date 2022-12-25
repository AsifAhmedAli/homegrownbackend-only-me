<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->text('featured_redirection')->nullable();
            $table->enum('type', [
              \App\Utils\Constants\DropDown::FIXED_PRODUCT,
              \App\Utils\Constants\DropDown::FIXED_CATEGORY,
              \App\Utils\Constants\DropDown::PERCENT_PRODUCT,
              \App\Utils\Constants\DropDown::PERCENT_CATEGORY
            ]);
            $table->integer('amount')->default(0);
            $table->double('minimum_spent')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('used_counter')->default(0);
            $table->integer('usage_limit')->default(0);
            $table->integer('usage_limit_per_user')->default(0);
            $table->longText('user_ids')->nullable();
            $table->longText('product_ids')->nullable();
            $table->longText('exclude_product_ids')->nullable();
            $table->longText('category_ids')->nullable();
            $table->longText('exclude_category_ids')->nullable();
            $table->boolean('is_shipping_free')->default(false);
            $table->boolean('status')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
