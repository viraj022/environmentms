<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainAssignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_assigned_complains');
        Schema::create('complain_assign_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('complain_id');
            $table->unsignedBigInteger('assigner_user');
            $table->unsignedBigInteger('assignee_user');
            $table->dateTime('assigned_time');
            $table->foreign('complain_id')->references('id')->on('complains')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('assigner_user')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('assignee_user')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('complain_assign_logs');
    }
}
