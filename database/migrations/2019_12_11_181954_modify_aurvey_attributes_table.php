<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAurveyAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_attributes', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('note');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_attributes', function (Blueprint $table) {
            $table->string('type',150)->comment('Selected,Text,Date,Numeric');
            $table->text('note')->nullable();
        });
    }
}
