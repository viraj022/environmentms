<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineApplicationRemoveColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->dropColumn('daily_tot_discharge');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->renameColumn('local_amount', 'land_amount');
            $table->renameColumn('foreign_amount', 'buildings_amount');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->float('land_amount')->nullable()->change();
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
            $table->string('daily_tot_discharge')->nullable();
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->renameColumn('land_amount', 'local_amount');
            $table->renameColumn('buildings_amount', 'foreign_amount');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->float('land_amount')->change();
        });
    }
}
