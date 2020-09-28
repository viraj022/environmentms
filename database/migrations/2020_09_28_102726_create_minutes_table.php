<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minutes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_type');
            $table->bigInteger('file_type_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->text('minute_description');
            $table->string('situation');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('minutes');
    }
}
