<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class AddMoreColumnsInKit extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('kits', function (Blueprint $table) {
        $table->string('title')->after('name');
        $table->string('mini_title')->after('title');
          $table->string('cta_1_title')->nullable()->after('images');
          $table->renameColumn('images', 'image');
        $table->string('cta_1_url', 300)->nullable()->after('cta_1_title');
        $table->string('cta_2_title')->nullable()->after('cta_1_url');
        $table->string('cta_2_url', 300)->nullable()->after('cta_1_title');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('kits', function (Blueprint $table) {
        $table->renameColumn('image', 'images');
        $table->dropColumn('title');
        $table->dropColumn('mini_title');
        $table->dropColumn('cta_1_title');
        $table->dropColumn('cta_1_url');
        $table->dropColumn('cta_2_title');
        $table->dropColumn('cta_2_url');
      });
    }
  }
