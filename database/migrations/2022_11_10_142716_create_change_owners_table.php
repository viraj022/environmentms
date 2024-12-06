<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_owners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->string('name_title');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('nic')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('industry_name');
            $table->string('industry_contact_no')->nullable();
            $table->text('industry_address');
            $table->string('industry_email')->nullable();
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
        Schema::dropIfExists('change_owners');
    }
}
