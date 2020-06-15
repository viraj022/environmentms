<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileHandlerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_handler_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 50);
            $table->bigInteger('environment_officer_id')->unsigned();
            $table->bigInteger('assistant_director_id')->unsigned();
            $table->foreign('environment_officer_id')->references('id')->on('environment_officers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('assistant_director_id')->references('id')->on('assistant_directors')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('file_handler_logs');
    }
}
