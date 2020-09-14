<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('file_approval_status',50)->default('file_init')->comment('file_init,ad_app_pending ,dir_app_pending,rejected,approved');
            $table->string('certificate_type_status',50)->default('undefined')->comment('epl_new,epl_renew,site_new,site_renew');
            $table->string('certificate_status',50)->default('eo_pending')->comment('eo_pending,ad_pending,dir_pending,drafted,approved,issued,hold');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
        $table->dropColumn('file_approval_status');
        $table->dropColumn('certificate_type_status');
        $table->dropColumn('certificate_status');
        });
    }
}
