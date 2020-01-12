<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurayParamAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suray_param_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parameter_id')->unsigned();
            $table->bigInteger('survey_attribute_id')->unsigned();
            $table->timestamps();
            $table->foreign('parameter_id')->references('id')->on('parameters')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('survey_attribute_id')->references('id')->on('survey_attributes')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suray_param_attributes');
    }
}
