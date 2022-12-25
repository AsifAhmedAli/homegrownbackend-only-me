<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydroProductUomConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydro_product_uom_conversions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hydro_product_id');
            $table->unsignedBigInteger('product_recid');
            $table->decimal('factor', 10, 2)->default(0)->nullable()->comment('The conversion multiplier between units');
            $table->integer('numerator')->default(0)->nullable()->comment('Numerator for conversion factor');
            $table->integer('denominator')->default(0)->nullable()->comment('Denominator for conversion factor');
            $table->decimal('inneroffset', 10, 2)->default(0)->nullable()->comment('Offset added to numerator');
            $table->decimal('outeroffset', 10, 2)->default(0)->nullable()->comment('Offset added to denominator');
            $table->integer('rounding')->default(0)->nullable()->comment('Denotes how UoM conversion results should be rounded');
            $table->string('fromsymbol')->nullable()->comment('Abbreviation of "from" conversion unit');
            $table->integer('fromdecimalofprecision')->default(0)->nullable()->comment('Denotes how many decimal places to display in "from" value');
            $table->string('fromname')->nullable()->comment('Specifies the “from” conversion unit');
            $table->string('tosymbol')->nullable()->comment('Abbreviation of "to" conversion unit');
            $table->integer('todecimalofprecision')->default(0)->nullable()->comment('Denotes how many decimal places to display in "to" value');
            $table->string('toname')->nullable()->comment('Specifies the "to" conversion unit');
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
        Schema::dropIfExists('hydro_product_uom_conversions');
    }
}
