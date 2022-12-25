<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OfferFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('offer_features', function (Blueprint $table) {
        $table->id();
        $table->string('image')->nullable();
        $table->string('title');
        $table->string('slug');
        $table->longText('description')->nullable();
        $table->tinyInteger('is_active')->default(0);
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
        Schema::dropIfExists('offer_features');
    }
}
