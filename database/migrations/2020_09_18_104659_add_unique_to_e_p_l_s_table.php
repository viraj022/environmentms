<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueToEPLSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->string('certificate_no')->unique()->change();
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
            $table->string('certificate_no')->change();
        });
    }
}
