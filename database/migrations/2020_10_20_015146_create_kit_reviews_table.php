<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kit_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kit_id')->constrained()->onDelete('cascade');
            $table->double('rating')->default(0);
            $table->string('reviewer_name');
            $table->text('comment');
            $table->tinyInteger('is_approved')->default(0);
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
        Schema::dropIfExists('kit_reviews');
    }
}
