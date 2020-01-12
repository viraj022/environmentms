<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivilegeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privilege_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('privilege_id')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->boolean('is_read')->unsigned();
            $table->boolean('is_create')->unsigned();
            $table->boolean('is_update')->unsigned();
            $table->boolean('is_delete')->unsigned();
            $table->timestamps();
            $table->foreign('privilege_id')->references('id')->on('privileges')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['user_id','privilege_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privilege_user');
    }
}
