<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaInHowItWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('how_it_work', function (Blueprint $table) {
          $table->string('meta_title')->nullable()->after('upload_book');
          $table->text('meta_description')->nullable()->after('meta_title');
          $table->text('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('how_it_work', function (Blueprint $table) {
            //
        });
    }
}
