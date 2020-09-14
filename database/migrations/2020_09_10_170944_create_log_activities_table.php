<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject', 255);
            $table->string('table')->nullable();
            $table->bigInteger('field')->nullable()->unsigned();
            $table->string('user_id', 255);
            $table->text('url');
            $table->text('ip');
            $table->text('method');
            $table->text('headers');
            $table->text('request_data')->nullable();
            $table->integer('response_code')->nullable();
            $table->text('response_data')->nullable();
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
        Schema::dropIfExists('log_activities');
    }
}
