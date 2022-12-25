<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailchimpAutomationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailchimp_automations', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('cart_id');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
          $table->timestamp('added_to_mailchimp_at')->nullable()->after('password');
        });
        Schema::table('hydro_products', function (Blueprint $table) {
          $table->timestamp('added_to_mailchimp_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailchimp_automations');
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('added_to_mailchimp_at');
        });
        Schema::table('hydro_products', function (Blueprint $table) {
          $table->dropColumn('added_to_mailchimp_at');
        });
    }
}
