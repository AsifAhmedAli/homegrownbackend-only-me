<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGxPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gx_pricings', function (Blueprint $table) {
            $table->id();
            $table->string('tittle');
            $table->string('banner_title')->nullable();
            $table->text('banner_description')->nullable();
            $table->string('banner_cta_title')->nullable();
            $table->string('banner_cta_url')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('content_title')->nullable();
            $table->text('content')->nullable();
            $table->string('included_title')->nullable();
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
        Schema::dropIfExists('gx_pricings');
    }
}
