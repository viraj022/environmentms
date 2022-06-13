<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToInspectionSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspection_sessions', function (Blueprint $table) {
            $table->string('ownersip')->nullable();
            $table->string('adj_land_n')->nullable();
            $table->string('adj_land_s')->nullable();
            $table->string('adj_land_e')->nullable();
            $table->string('adj_land_w')->nullable();
            $table->string('sensitive_area_desc')->nullable();
            $table->string('special_issue_desc')->nullable();
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
            $table->dropColumn('ownersip');
            $table->dropColumn('adj_land_n');
            $table->dropColumn('adj_land_s');
            $table->dropColumn('adj_land_e');
            $table->dropColumn('adj_land_w');
            $table->dropColumn('sensitive_area_desc');
            $table->dropColumn('special_issue_desc');
        });
    }
}
