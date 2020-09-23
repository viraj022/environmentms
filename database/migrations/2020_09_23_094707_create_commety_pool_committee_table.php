<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommetyPoolCommitteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commety_pool_committee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('committee_id')->unsigned();
            $table->bigInteger('commety_pool_id')->unsigned();
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('commety_pool_id')->references('id')->on('commety_pools')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commety_pool_committee');
    }
}
