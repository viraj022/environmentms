<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionSessionAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_session_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inspection_session_id')->unsigned();
            $table->text('path');
            $table->string('type', 50);
            $table->timestamps();
            $table->foreign('inspection_session_id')->references('id')->on('inspection_sessions')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspection_session_attachments');
    }
}
