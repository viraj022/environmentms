<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 50);
            $table->bigInteger('type_id')->unsigned();
            $table->string('officer_type', 50)->comment('director , a_director,officer');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->integer('status')->comment('approve=> 0 reject=>1');
            $table->dateTime('approve_date');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approval_logs');
    }
}
