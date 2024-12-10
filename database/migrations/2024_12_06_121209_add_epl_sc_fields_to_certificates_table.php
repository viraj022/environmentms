<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEplScFieldsToCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('epl_id')->nullable()->foreign('epl_id')->references('id')->on('e_p_l_s');
            $table->string('sc_id')->nullable()->foreign('sc_id')->references('id')->on('site_clearances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['epl_id']);
            $table->dropForeign(['sc_id']);
            $table->dropColumn(['epl_id', 'sc_id']);
        });
    }
}
