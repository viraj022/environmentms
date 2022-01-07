<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('compliner_name', 255);
            $table->string('compliner_address', 255);
            $table->string('comp_contact_no', 12);
            $table->tinyInteger('recieve_type');
            $table->tinyInteger('status');
            $table->string('complain_des', 255);
            $table->unsignedBigInteger('assigned_user')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->foreign('assigned_user')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('created_user')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('complains');
    }
}
