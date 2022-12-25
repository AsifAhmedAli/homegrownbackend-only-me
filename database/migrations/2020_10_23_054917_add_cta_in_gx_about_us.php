<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class AddCtaInGxAboutUs extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('gx_about_us', function (Blueprint $table) {
        $table->string('section_4_cta_title')->nullable()->after('section_4_description');
        $table->string('section_4_cta_link')->nullable()->after('section_4_cta_title');
        $table->string('section_5_cta_title')->nullable()->after('section_5_description');
        $table->string('section_5_cta_link')->nullable()->after('section_5_cta_title');
        $table->string('section_6_cta_title')->nullable()->after('section_6_description');
        $table->string('section_6_cta_link')->nullable();
      });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('gx_about_us', function (Blueprint $table) {
        $table->dropColumn('section_4_cta_title', 'section_4_cta_link', 'section_5_cta_title', 'section_5_cta_link',
          'section_6_cta_title', 'section_6_cta_link');
        
      });
    }
  }
