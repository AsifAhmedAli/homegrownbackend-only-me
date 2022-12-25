<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class AddMetaInAboutUs extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('about_us', function (Blueprint $table) {
        $table->string('meta_title')->nullable()->after('distribution_heading');
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
      Schema::table('about_us', function (Blueprint $table) {
        //
      });
    }
  }
