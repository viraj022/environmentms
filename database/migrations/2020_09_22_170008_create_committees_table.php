<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->bigInteger('site_clearence_session_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->text('remark')->nullable();
            $table->date('schedule_date')->nullable();            
            $table->timestamps();
            $table->softDeletes();       
            $table->foreign('site_clearence_session_id')->references('id')->on('site_clearence_sessions')->onDelete('cascade')->onUpdate('cascade');     
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');     
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('committees');
    }
}
