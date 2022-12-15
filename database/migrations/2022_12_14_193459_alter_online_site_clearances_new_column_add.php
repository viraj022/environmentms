<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineSiteClearancesNewColumnAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->string('sc_type')->nullable()->after('online_request_id');
            $table->text('odour_abatement')->nullable()->after('noise_abatement');
            $table->string('contact_person_email')->nullable()->after('contact_person_number');
            $table->string('developing_land_area')->nullable()->after('plan_description');
            $table->string('land_ownership_type')->after('developing_land_area');
            $table->float('within_buffer_zone_m', 8, 2)->nullable()->after('land_ownership_type');
            $table->string('w_discharge_method')->nullable()->after('within_buffer_zone_m');
            $table->text('solid_disposal')->nullable()->after('w_discharge_method');
            $table->float('tot_other_supply', 10, 2)->nullable()->after('solid_disposal');
            $table->text('machines')->nullable()->after('tot_other_supply');
            $table->string('fuel_type')->nullable()->after('fuel_use');
            $table->text('chimney')->nullable()->after('machines');
            $table->string('air_emission_report')->nullable()->after('chimney');
            $table->string('old_sc_cer')->nullable()->after('air_emission_report');
            $table->string('building_plan')->nullable()->after('old_sc_cer');
            $table->string('deed_of_land')->nullable()->after('building_plan');
            $table->string('survey_plan')->nullable()->after('deed_of_land');
            $table->string('business_reg_cer')->nullable()->after('survey_plan');
            $table->string('project_report')->nullable()->after('business_reg_cer');
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
            $table->dropColumn('sc_type');
            $table->dropColumn('odour_abatement');
            $table->dropColumn('contact_person_email');
            $table->dropColumn('developing_land_area');
            $table->dropColumn('land_ownership_type');
            $table->dropColumn('within_buffer_zone_m');
            $table->dropColumn('w_discharge_method');
            $table->dropColumn('solid_disposal');
            $table->dropColumn('tot_other_supply');
            $table->dropColumn('machines');
            $table->dropColumn('fuel_type');
            $table->dropColumn('chimney');
            $table->dropColumn('air_emission_report');
            $table->dropColumn('old_sc_cer');
            $table->dropColumn('building_plan');
            $table->dropColumn('deed_of_land');
            $table->dropColumn('survey_plan');
            $table->dropColumn('business_reg_cer');
            $table->dropColumn('project_report');
        });
    }
}
