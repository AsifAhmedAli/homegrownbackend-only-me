<?php
  
  use App\Page;
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreatePagesTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pages', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('body');
        $table->string('image')->nullable();
        $table->tinyInteger('is_active')->default(0);
        $table->string('meta_title')->nullable();
        $table->text('meta_description')->nullable();
        $table->text('meta_keywords')->nullable();
        $table->timestamps();
        
      });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('pages');
    }
  }
