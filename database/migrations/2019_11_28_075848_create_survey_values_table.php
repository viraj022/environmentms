<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->unsignedBigInteger('survey_attribute_id');
            $table->timestamps();
            $table->foreign('survey_attribute_id')->references('id')->on('survey_attributes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_values');
    }
}
