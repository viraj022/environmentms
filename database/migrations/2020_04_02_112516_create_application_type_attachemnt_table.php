<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTypeAttachemntTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_type_attachemnt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("attachemnt_id")->unsigned();
            $table->bigInteger("application_type_id")->unsigned();
            $table->foreign('attachemnt_id')->references('id')->on('attachemnts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('application_type_id')->references('id')->on('application_types')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('application_type_attachemnt');
    }
}
