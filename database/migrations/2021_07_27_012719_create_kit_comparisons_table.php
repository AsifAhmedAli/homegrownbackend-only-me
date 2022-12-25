<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitComparisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kit_comparisons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('short_description')->nullable();
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->string('kit_name_1')->nullable();
            $table->string('kit_name_2')->nullable();
            $table->string('kit_name_3')->nullable();
            $table->string('price_1')->nullable();
            $table->string('price_2')->nullable();
            $table->string('price_3')->nullable();
            $table->text('content_1')->nullable();
            $table->text('content_2')->nullable();
            $table->text('content_3')->nullable();
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
        Schema::dropIfExists('kit_comparisons');
    }
}
