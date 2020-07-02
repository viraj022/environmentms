<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('certificate_type', 50);
            $table->string('issue_type', 50);
            $table->bigInteger('issue_id')->unsigned();
            $table->dateTime('issue_date');
            $table->dateTime('expire_date');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('issue_logs');
    }
}
