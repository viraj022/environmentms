<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZoneIdToPradesheeyasabasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pradesheeyasabas', function (Blueprint $table) {
        $table->bigInteger('zone_id')->unsigned()->nullable();
        $table->foreign('zone_id')->references('id')->on('zones')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pradesheeyasabas', function (Blueprint $table) {
        $table->dropForeign('pradesheeyasabas_zone_id_foreign');
        $table->dropColumn('zone_id');
        });
    }
}
