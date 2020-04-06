<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommetyPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commety_pools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('nic', 255);
            $table->string('address', 255);
            $table->string('contact_no', 12);
            $table->string('email', 255);
            $table->bigInteger('local_authority_id')->unsigned();
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
        Schema::dropIfExists('commety_pools');
    }
}
