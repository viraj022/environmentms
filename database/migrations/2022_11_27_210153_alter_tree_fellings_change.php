<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTreeFellingsChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tree_fellings', function (Blueprint $table) {
            $table->text('current_land_use')->nullable()->change();
            $table->text('tree_felling_reason')->nullable()->change();
            $table->text('land_pattern_within_100m')->nullable()->change();
            $table->text('rehabilitation_plan')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('extent_of_land')->nullable()->change();
            $table->string('deed_number')->nullable()->change();
            $table->string('survey_plan_number')->nullable()->change();
        });

        Schema::table('state_land_leases', function (Blueprint $table) {
            $table->text('purpose')->nullable()->change();
        });

        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->string('contact_person_designation')->nullable()->change();
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
            $table->string('current_land_use')->change();
            $table->text('tree_felling_reason')->change();
            $table->text('land_pattern_within_100m')->change();
            $table->string('rehabilitation_plan')->nullable()->change();
            $table->string('email')->change();
            $table->string('extent_of_land')->change();
            $table->string('deed_number')->change();
            $table->string('survey_plan_number')->change();
        });

        Schema::table('state_land_leases', function (Blueprint $table) {
            $table->string('purpose')->nullable()->change();
        });

        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->string('contact_person_designation')->change();
        });
    }
}
