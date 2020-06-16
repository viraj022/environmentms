<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEPLAttachemntTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_p_l_attachemnt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('attachemnt_id')->unsigned();
            $table->bigInteger('e_p_l_id')->unsigned();
            $table->foreign('e_p_l_id')->references('id')->on('e_p_l_s')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('attachemnt_id')->references('id')->on('attachemnts')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('e_p_l_attachemnt');
    }
}
