<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamapthKendrayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samapth_kendrayas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->text('address')->nullable();
            $table->string('contactNo', 12)->nullable();
            $table->bigInteger('local_authority_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('local_authority_id')->references('id')->on('local_authorities')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('samapth_kendrayas');
    }
}
