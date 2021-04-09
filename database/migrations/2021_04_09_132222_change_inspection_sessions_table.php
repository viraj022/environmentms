<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInspectionSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspection_sessions', function (Blueprint $table) {
          $table->text('sketch_path')->nullable();
          $table->double('proposed_land_ext', 8, 2);
          $table->string('project_area_type')->nullable();
          $table->string('land_use')->nullable();
          $table->string('100_to_300')->nullable();
          $table->string('within_500')->nullable();
          $table->string('house_within_100')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspection_sessions', function (Blueprint $table) {
          $table->dropColumn('sketch_path');
          $table->dropColumn('proposed_land_ext', 8, 2);
          $table->dropColumn('project_area_type');
          $table->dropColumn('land_use');
          $table->dropColumn('100_to_300');
          $table->dropColumn('within_500');
          $table->dropColumn('house_within_100');
        });
    }
}