<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistantDirectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistant_directors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('zone_id')->unsigned();
            $table->integer('active_status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('restrict')->onUpdate('cascade');
        });


        // DB::unprepared('
        // CREATE TRIGGER tringger AFTER INSERT ON `` FOR EACH ROW
        //  BEGIN
        //         # do some stuff
        //     END
        //  ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assistant_directors');
    }
}
