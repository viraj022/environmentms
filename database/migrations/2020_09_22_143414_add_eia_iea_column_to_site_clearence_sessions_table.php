<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEiaIeaColumnToSiteClearenceSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_clearence_sessions', function (Blueprint $table) {
            $table->integer('processing_status')->default(0)->comment('0 = > pending , 1 => site_clearance , 2 => EIA , 3 => IEA')->after('site_clearance_type');
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
            $table->dropColumn('processing_status');
        });
    }
}
