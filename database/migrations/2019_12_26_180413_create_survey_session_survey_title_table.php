<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveySessionSurveyTitleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_session_survey_title', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('survey_session_id')->unsigned();
            $table->bigInteger('survey_title_id')->unsigned();
            $table->timestamps();
            $table->foreign('survey_session_id')->references('id')->on('survey_sessions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('survey_title_id')->references('id')->on('survey_titles')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_session_survey_title');
    }
}
