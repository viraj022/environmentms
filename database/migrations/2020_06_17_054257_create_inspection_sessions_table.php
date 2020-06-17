<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_type_id')->unsigned();
            $table->bigInteger('profile_id')->unsigned();
            $table->text('remark')->nullable();
            $table->integer('status')->unsigned()->comment('0 => pending 1=> inspection started')->default(0);
            $table->dateTime('schedule_date');
            $table->softDeletes();
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
        Schema::dropIfExists('inspection_sessions');
    }
}
