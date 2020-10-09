<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSiteClearenceSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_clearence_sessions', function (Blueprint $table) {
            $table->date('issue_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('licence_no')->nullable();
            $table->integer('status')->default(0)->comment('0 not issued 1 issued');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_clearence_sessions', function (Blueprint $table) {
            $table->dropColumn('issue_date');
            $table->dropColumn('expire_date');
            $table->dropColumn('issue_status');
            $table->dropColumn('licence_no');
        });
    }
}
