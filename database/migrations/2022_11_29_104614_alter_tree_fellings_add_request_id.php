<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTreeFellingsAddRequestId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tree_fellings', function (Blueprint $table) {
            $table->unsignedBigInteger('online_request_id')->after('id');
        });

        Schema::table('state_land_leases', function (Blueprint $table) {
            $table->unsignedBigInteger('online_request_id')->after('id');
        });

        Schema::table('refiling_paddy_lands', function (Blueprint $table) {
            $table->unsignedBigInteger('online_request_id')->after('id');
        });

        Schema::table('telecommunication_towers', function (Blueprint $table) {
            $table->unsignedBigInteger('online_request_id')->after('id');
            $table->string('land_address')->after('pradeshiya_sabha');
        });

        Schema::table('waste_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('online_request_id')->after('id');
        });

        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->unsignedBigInteger('online_request_id')->after('id');
            $table->string('sc_type')->nullable()->after('online_request_id');
            $table->string('industry_address')->after('other_industry_type');
            $table->text('odour_abatement')->nullable()->after('noise_abatement');
        });

        Schema::table('online_renewal_epls', function (Blueprint $table) {
            $table->unsignedBigInteger('online_request_id')->after('id');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->unsignedBigInteger('online_request_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tree_fellings', function (Blueprint $table) {
            $table->dropColumn('online_request_id');
        });

        Schema::table('state_land_leases', function (Blueprint $table) {
            $table->dropColumn('online_request_id');
        });

        Schema::table('refiling_paddy_lands', function (Blueprint $table) {
            $table->dropColumn('online_request_id');
        });

        Schema::table('telecommunication_towers', function (Blueprint $table) {
            $table->dropColumn('online_request_id');
            $table->dropColumn('land_address');
        });

        Schema::table('waste_managements', function (Blueprint $table) {
            $table->dropColumn('online_request_id');
        });

        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->dropColumn('online_request_id');
            $table->dropColumn('sc_type');
            $table->dropColumn('industry_address');
            $table->dropColumn('odour_abatement');
        });

        Schema::table('online_renewal_epls', function (Blueprint $table) {
            $table->dropColumn('online_request_id');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->dropColumn('online_request_id');
        });
    }
}
