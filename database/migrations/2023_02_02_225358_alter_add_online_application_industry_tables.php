<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddOnlineApplicationIndustryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->text('industryDetailCheck')->nullable()->after('plan_description');
        });

        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->text('industryDetailCheck')->nullable()->after('refinery_waste_water');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->dropColumn('industryDetailCheck');
        });

        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->dropColumn('industryDetailCheck');
        });
    }
}
