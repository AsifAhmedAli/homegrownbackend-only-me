<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProviderColInPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->enum('provider', [\App\Utils\Constants\Constant::HGP, \App\Utils\Constants\Constant::GX])
                ->default(\App\Utils\Constants\Constant::HGP)
                ->after('id');
            $table->dropUnique(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('provider');
            $table->unique('slug');
        });
    }
}
