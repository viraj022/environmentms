<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('register_no', 10)->unique();
            $table->decimal('capacity')->unsigned();
            $table->decimal('wide')->unsigned();
            $table->decimal('length')->unsigned();
            $table->decimal('height')->unsigned();
            $table->integer('production_year')->unsigned();
            $table->string('bland', 20);
            $table->string('condition', 20)->comment('Good,Moderate,Bad/Out of order');
            $table->string('dump_type', 10)->comment('transfer , Dump , Dump and Transfer');
            $table->String('ownership', 20)->nullable()->comment('LA,Private,LA And Private');
            $table->bigInteger('local_authority_id')->unsigned();;
            $table->bigInteger('ward_id')->unsigned()->nullable();
            $table->bigInteger('vehicle_type_id')->unsigned();
            $table->foreign('local_authority_id')->references('id')->on('local_authorities')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('vehicles');
    }
}
