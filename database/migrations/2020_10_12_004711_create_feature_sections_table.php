<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_sections', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->foreignId('feature_id')->default(1)->constrained('features')->onDelete('cascade');
          $table->string('title');
          $table->text('description');
          $table->string('image');
          $table->string('cta_title');
          $table->string('cta_link');
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
        Schema::dropIfExists('feature_sections');
    }
}
