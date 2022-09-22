<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineRenewalApplicationAddAttachment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_renewal_application_requests', function (Blueprint $table) {
            $table->string('road_map')->nullable()->after('status');
            $table->string('deed_of_land')->nullable()->after('road_map');
            $table->string('survey_plan')->nullable()->after('deed_of_land');
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
            $table->dropColumn('road_map');
            $table->dropColumn('deed_of_land');
            $table->dropColumn('survey_plan');
        });
    }
}
