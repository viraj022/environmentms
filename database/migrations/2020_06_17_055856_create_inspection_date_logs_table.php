<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionDateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_date_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inspection_session_id')->unsigned();
            $table->dateTime('date');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('inspection_date_logs');
    }
}
