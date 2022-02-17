<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainMinutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complain_minutes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('minute');
            $table->unsignedBigInteger('complain_id');
            $table->unsignedBigInteger('minute_user_id');
            $table->foreign('complain_id')->references('id')->on('complains')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('minute_user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('complain_minutes');
    }
}
