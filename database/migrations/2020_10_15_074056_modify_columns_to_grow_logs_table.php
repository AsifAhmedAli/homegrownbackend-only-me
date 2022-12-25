<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsToGrowLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grow_logs', function (Blueprint $table) {
            $table->dropColumn('lighting_type');
            $table->foreignId('lighting_type_id')->nullable()->after('cycle_light')->constrained()->onDelete('SET NULL');
          $table->dropColumn('media_type');
          $table->foreignId('media_type_id')->nullable()->after('lighting_type_id')->constrained()->onDelete('SET NULL');
          $table->dropColumn('strain');
          $table->foreignId('strain_id')->nullable()->after('media_type_id')->constrained()->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grow_logs', function (Blueprint $table) {
            $table->dropForeign(['lighting_type_id']);
            $table->dropForeign(['media_type_id']);
            $table->dropForeign(['strain_id']);
            $table->dropColumn('lighting_type_id', 'media_type_id', 'strain_id');
            $table->string('lighting_type')->nullable()->after('cycle_light');
            $table->string('media_type')->nullable()->after('lighting_type');
            $table->string('strain')->nullable()->after('media_type');
        });
    }
}
