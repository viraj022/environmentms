<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteClearenceSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_clearence_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
            $table->text('remark')->nullable();
            $table->bigInteger('client_id')->unsigned();
            $table->string('site_clearance_type')->comment('');  // add comments
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_clearence_sessions');
    }
}
