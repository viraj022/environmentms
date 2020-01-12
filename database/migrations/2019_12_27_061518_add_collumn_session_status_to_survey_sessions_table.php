<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnSessionStatusToSurveySessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_sessions', function (Blueprint $table) {
            $table->integer('session_status')->unsigned()->default(0)->comment('0 Not Started 1 started 2 finished');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_sessions', function (Blueprint $table) {
            $table->dropColumn('session_status');
        });
    }
}
