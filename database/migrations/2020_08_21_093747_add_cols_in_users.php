<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 50)->after('name');
            $table->string('last_name', 50)->after('first_name');
            $table->string('company_name', 50)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('street_address_1', 150)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('zip_code', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name', 'last_name', 'company_name', 'city', 'state', 'street_address_1', 'zip_code');
        });
    }
}
