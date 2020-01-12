<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalAuthoritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_authorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('type',50)->comment('MunicipalCouncil UrbanCouncil PradesheysSaba');
            $table->text('address')->nullable();
            $table->string('laCode')->nullable();
            $table->unsignedBigInteger('provincial_council_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('provincial_council_id')->references('id')->on('provincial_councils')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_authorities');
    }
}
