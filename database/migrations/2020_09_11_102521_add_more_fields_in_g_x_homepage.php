<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class AddMoreFieldsInGXHomepage extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('gx_home_page', function (Blueprint $table) {
        $table->string('team_title')->after('instagram_section_buttom_description');
        $table->string('team_cta_title')->after('team_title');
        $table->string('team_cta_url')->after('team_cta_title');
        $table->string('meta_title')->nullable()->after('upload_book');
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
      Schema::table('gx_home_page', function (Blueprint $table) {
        $table->dropColumn('team_title');
        $table->dropColumn('team_cta_title');
        $table->dropColumn('team_cta_url');
        $table->dropColumn('meta_title');
        $table->dropColumn('meta_keywords');
        $table->dropColumn('meta_description');
      });
    }
  }
