<?php
  
  use App\Page;
  use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_sections', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('page_id')->nullable();
          $table->string('title')->nullable();
          $table->string('image')->nullable();
          $table->text('description');
          $table->tinyInteger('is_active')->default(0);
          $table->timestamps();
          $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_sections');
    }
}
