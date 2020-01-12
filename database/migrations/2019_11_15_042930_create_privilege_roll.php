<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivilegeRoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privilege_roll', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('privilege_id');
            $table->unsignedBigInteger('roll_id');
            $table->boolean('is_read');
            $table->boolean('is_create');
            $table->boolean('is_update');
            $table->boolean('is_delete');
            $table->foreign('privilege_id')->references('id')->on('privileges')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('roll_id')->references('id')->on('rolls')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['roll_id','privilege_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privilege_roll');
    }
}
