<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class GiveMediaDeletePermissionToAdmin extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES (4,2);');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('permission_role', function (Blueprint $table) {
        //
      });
    }
  }
