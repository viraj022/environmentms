<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteClearancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_clearances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('submit_date')->nullable();
            $table->datetime('issue_date')->nullable();
            $table->datetime('expire_date')->nullable();
            $table->text('application_path')->nullable();
            $table->text('certificate_path')->nullable();
            $table->bigInteger('site_clearence_session_id')->unsigned();
            $table->integer('count');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('site_clearence_session_id')->references('id')->on('site_clearence_sessions')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_clearances');
    }
}
