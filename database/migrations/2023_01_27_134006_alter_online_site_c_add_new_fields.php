<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineSiteCAddNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->string('nic')->nullable()->after('applicant_number');
            $table->text('tot_discharge_per_day')->nullable()->after('project_report');
            $table->text('contaminants')->nullable()->after('tot_discharge_per_day');
            $table->text('refinery_waste_water')->nullable()->after('contaminants');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->string('industry_br')->nullable()->after('plan_description');
            $table->string('nic')->nullable()->after('industry_br');
            $table->text('industry_nature')->nullable()->after('nic');
            $table->string('industry_GPS')->nullable()->after('industry_nature');
            $table->string('telephone_Number')->nullable()->after('industry_GPS');
            $table->text('industrial_zone2')->nullable()->after('telephone_Number');
            $table->text('industrial_zone3')->nullable()->after('industrial_zone2');
            $table->text('industrial_zone4')->nullable()->after('industrial_zone3');
            $table->text('industrial_zone5')->nullable()->after('industrial_zone4');
            $table->float('machinery_amount', 8, 2)->nullable()->after('industrial_zone5');
        });

        Schema::table('tree_fellings', function (Blueprint $table) {
            $table->string('route_map')->nullable()->after('landowners_affidavit');
        });

        Schema::table('waste_managements', function (Blueprint $table) {
            $table->text('site_collecion')->nullable()->after('disposal_des');
            $table->text('proposed_date_frequency')->nullable()->after('site_collecion');
            $table->text('estimate_quatity_to_collect')->nullable()->after('proposed_date_frequency');
            $table->text('type_of_parking')->nullable()->after('estimate_quatity_to_collect');
            $table->text('mode_of_transpotation')->nullable()->after('type_of_parking');
            $table->text('class_type_of_vehicles')->nullable()->after('mode_of_transpotation');
            $table->text('registered_number')->nullable()->after('class_type_of_vehicles');
            $table->text('number_of_vehicles')->nullable()->after('registered_number');
            $table->text('route_details')->nullable()->after('number_of_vehicles');
            $table->text('emergency_measure')->nullable()->after('route_details');
            $table->text('location_of_extend_storage_site')->nullable()->after('emergency_measure');
            $table->text('type_of_parking_enviasaged')->nullable()->after('location_of_extend_storage_site');
            $table->text('period_of_time_waste')->nullable()->after('type_of_parking_enviasaged');
            $table->text('information_relating_recycling')->nullable()->after('period_of_time_waste');
            $table->text('emergency_measures_adopted')->nullable()->after('information_relating_recycling');
            $table->text('location_of_recovery_facilities')->nullable()->after('emergency_measures_adopted');
            $table->text('methord_used_in_the_recovery')->nullable()->after('location_of_recovery_facilities');
            $table->text('purpose_of_recycling')->nullable()->after('methord_used_in_the_recovery');
            $table->text('emergency_measure_adoped_in_the_events')->nullable()->after('purpose_of_recycling');
            $table->text('location_of_the_site_for_disposal')->nullable()->after('emergency_measure_adoped_in_the_events');
            $table->text('method_of_disposal')->nullable()->after('location_of_the_site_for_disposal');
            $table->text('description_of_the_treatment_process')->nullable()->after('method_of_disposal');
            $table->text('information_on_the_after_care')->nullable()->after('description_of_the_treatment_process');
            $table->text('emergency_measures_adopted_site_accident')->nullable()->after('information_on_the_after_care');
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
            $table->dropColumn('nic');
            $table->dropColumn('tot_discharge_per_day');
            $table->dropColumn('contaminants');
            $table->dropColumn('refinery_waste_water');
        });

        Schema::table('online_new_epls', function (Blueprint $table) {
            $table->dropColumn('industry_br');
            $table->dropColumn('nic');
            $table->dropColumn('industry_nature');
            $table->dropColumn('industry_GPS');
            $table->dropColumn('telephone_Number');
            $table->dropColumn('industrial_zone2');
            $table->dropColumn('industrial_zone3');
            $table->dropColumn('industrial_zone4');
            $table->dropColumn('industrial_zone5');
            $table->dropColumn('machinery_amount');
        });

        Schema::table('tree_fellings', function (Blueprint $table) {
            $table->dropColumn('route_map');
        });

        Schema::table('waste_managements', function (Blueprint $table) {
            $table->dropColumn('site_collecion');
            $table->dropColumn('proposed_date_frequency');
            $table->dropColumn('estimate_quatity_to_collect');
            $table->dropColumn('type_of_parking');
            $table->dropColumn('mode_of_transpotation');
            $table->dropColumn('class_type_of_vehicles');
            $table->dropColumn('registered_number');
            $table->dropColumn('number_of_vehicles');
            $table->dropColumn('route_details');
            $table->dropColumn('emergency_measure');
            $table->dropColumn('location_of_extend_storage_site');
            $table->dropColumn('type_of_parking_enviasaged');
            $table->dropColumn('period_of_time_waste');
            $table->dropColumn('information_relating_recycling');
            $table->dropColumn('emergency_measures_adopted');
            $table->dropColumn('location_of_recovery_facilities');
            $table->dropColumn('methord_used_in_the_recovery');
            $table->dropColumn('purpose_of_recycling');
            $table->dropColumn('emergency_measure_adoped_in_the_events');
            $table->dropColumn('location_of_the_site_for_disposal');
            $table->dropColumn('method_of_disposal');
            $table->dropColumn('description_of_the_treatment_process');
            $table->dropColumn('information_on_the_after_care');
            $table->dropColumn('emergency_measures_adopted_site_accident');
        });
    }
}
