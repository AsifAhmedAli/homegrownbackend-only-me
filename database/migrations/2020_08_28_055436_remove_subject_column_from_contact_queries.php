<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSubjectColumnFromContactQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_queries', function (Blueprint $table) {
          if (Schema::hasColumn('contact_queries', 'subject'))
          {
            Schema::table('contact_queries', function (Blueprint $table)
            {
              $table->dropColumn('subject');
            });
          }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_queries', function (Blueprint $table) {
            //
        });
    }
}
