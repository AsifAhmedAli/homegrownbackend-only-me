<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroProductDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_product_documents', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('hydro_product_id');
          $table->unsignedBigInteger('product_recid');
          $table->string('docName')->nullable();
          $table->string('fileName')->nullable();
          $table->string('fileType')->nullable();
          $table->boolean('isDefault')->nullable();
          $table->text('url')->nullable();
          $table->dateTimeTz('lastModified')->nullable();
          $table->timestamps();
  
          $table->foreign('hydro_product_id')->references('id')->on('hydro_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hydro_product_documents');
    }
}
