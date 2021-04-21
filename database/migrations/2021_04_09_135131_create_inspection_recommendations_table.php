<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_recommendations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('recommendation')->nullable();
            $table->bigInteger('inspection_session_id')->unsigned()->nullable();
            $table->foreign('inspection_session_id')->references('id')->on('inspection_sessions')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspection_recommendations');
    }
}
