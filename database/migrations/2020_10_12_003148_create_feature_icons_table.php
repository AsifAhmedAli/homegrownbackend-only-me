<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_icons', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->foreignId('feature_id')->default(1)->constrained('features')->onDelete('cascade');
          $table->string('title');
          $table->text('description');
          $table->string('image')->nullable();
          $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('feature_icons');
    }
}
