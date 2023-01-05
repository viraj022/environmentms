<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineSiteClearanceAddOldScNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->string('old_sc_number')->nullable()->after('sc_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->dropColumn('old_sc_number');
        });
    }
}
