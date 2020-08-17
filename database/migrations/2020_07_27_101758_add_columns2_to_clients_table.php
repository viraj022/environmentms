<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumns2ToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->text('application_path')->nullable();
            $table->bigInteger('environment_officer_id')->unsigned()->nullable();
            $table->text('file_01')->nullable();
            $table->text('file_02')->nullable();
            $table->text('file_03')->nullable();
            $table->foreign('environment_officer_id')->references('id')->on('environment_officers')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
