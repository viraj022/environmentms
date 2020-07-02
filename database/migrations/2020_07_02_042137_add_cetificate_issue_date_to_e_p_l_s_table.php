<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCetificateIssueDateToEPLSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->dateTime('issue_date')->nullable();
            $table->dateTime('renew_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->string('certificate_no')->nullable();
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
            $table->dropColumn('issue_date');
            $table->dropColumn('renew_date');
            $table->dropColumn('expire_date');
            $table->dropColumn('certificate_no');
        });
    }
}
