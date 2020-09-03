<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOfficerIdToInspectionSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspection_sessions', function (Blueprint $table) {
            $table->bigInteger('environment_officer_id')->unsigned()->nullable();
            $table->foreign('environment_officer_id')->references('id')->on('environment_officers')->onDelete('restrict')->onUpdate('cascade');
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
            $table->dropForeign('inspection_sessions_environment_officer_id_foreign');
            $table->dropColumn('environment_officer_id');
        });
    }
}
