<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hydro_id');
            $table->unsignedBigInteger('hydro_parent_id')->nullable();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->boolean('is_root')->default(false);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('hydro_categories');
    }
}
