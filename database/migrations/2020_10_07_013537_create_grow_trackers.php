<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrowTrackers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grow_trackers', function (Blueprint $table) {
            $table->id();
            $table->integer('week')->comment('Week')->default(1);
            $table->text('video_url');
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->text('helpful_resources')->nullable();
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
        Schema::dropIfExists('grow_trackers');
    }
}
