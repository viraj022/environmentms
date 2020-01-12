<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSurveyValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_values', function (Blueprint $table) {
            $table->dropForeign('survey_values_survey_attribute_id_foreign');          
            $table->dropColumn('survey_attribute_id');
            $table->unsignedBigInteger('suray_param_attributes_id');           
            $table->foreign('suray_param_attributes_id')->references('id')->on('suray_param_attributes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_values', function (Blueprint $table) {
            $table->dropForeign('survey_values_survey_suray_param_attributes_id');
            $table->dropColumn('suray_param_attributes_id');
            $table->unsignedBigInteger('survey_attribute_id');
            $table->foreign('survey_attribute_id')->references('id')->on('survey_attributes')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
