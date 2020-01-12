<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name',20)->unique();
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->text('address')->nullable();
            $table->string('contact_no',12)->nullable();
            $table->string('email',50)->nullable();
            $table->string('nic',12)->unique()->nullable();
            $table->unsignedBigInteger('roll_id');
            $table->string('password',80);
            $table->unsignedInteger('institute_Id')->nullable();
            $table->string('activeStatus',50)->default('Active')->comment('Active,Inactive,Archived');
            $table->foreign('roll_id')->references('id')->on('rolls')->onDelete('restrict')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
