<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddOtherIndTypeToOnlineApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->string('other_ind_type')->nullable()->after('other_industry_type');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->string('other_ind_type')->nullable()->after('industry_type');
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
            $table->dropColumn('other_ind_type');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->dropColumn('other_ind_type');
        });
    }
}
