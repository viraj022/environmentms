<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnvironmentOfficerCollumnToEPLSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->bigInteger('environment_officer_id')->unsigned()->nullable();
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
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->dropForeign('e_p_l_s_environment_officer_id_foreign');
            $table->dropColumn('environment_officer_id');
        });
    }
}
