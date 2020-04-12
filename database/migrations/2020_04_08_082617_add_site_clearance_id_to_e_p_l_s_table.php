<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteClearanceIdToEPLSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->string('site_clearance_file',50)->nullable();
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
            $table->dropColumn('site_clearance_file');
        });
    }
}
