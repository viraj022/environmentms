<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_personals', function (Blueprint $table) {         
            $table->bigIncrements('id');
            $table->bigInteger('inspection_session_id')->unsigned();
            $table->string('name',255);
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
        Schema::dropIfExists('inspection_personals');
    }
}
