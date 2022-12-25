<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('env');
            $table->text('access_token');
            $table->string('expires_in');
            $table->string('token_type')->default('Bearer');
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
        Schema::dropIfExists('hydro_tokens');
    }
}
