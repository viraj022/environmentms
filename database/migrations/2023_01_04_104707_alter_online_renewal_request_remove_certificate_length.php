<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineRenewalRequestRemoveCertificateLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_renewal_application_requests', function (Blueprint $table) {
            $table->string('certificate_number', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_renewal_application_requests', function (Blueprint $table) {
            $table->string('certificate_number', 15)->change();
        });
    }
}
