<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',150);
            $table->string('type',150)->comment('Selected,Text,Date,Numeric');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('survey_title_id');
            $table->timestamps();
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
        Schema::dropIfExists('survey_attributes');
    }
}
