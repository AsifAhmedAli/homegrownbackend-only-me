<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class AddColumnsInGXHowItWork extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('gx_how_it_works', function (Blueprint $table) {
        $table->string('name')->after('id');
        $table->string('meta_title')->nullable()->after('instagram_section_buttom_description');
        $table->text('meta_keywords')->nullable()->after('meta_title');
        $table->text('meta_description')->nullable()->after('meta_keywords');
      });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('gx_how_it_works', function (Blueprint $table) {
        $table->dropColumn('name');
        $table->dropColumn('meta_title');
        $table->dropColumn('meta_description');
        $table->dropColumn('meta_keywords');
      });
    }
  }
