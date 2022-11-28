<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineNewEplsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_new_epls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('industry_name');
            $table->string('industry_type');
            $table->string('other_industry_type')->nullable();
            $table->string('applicant_name');
            $table->text('applicant_address');
            $table->string('applicant_telephone');
            $table->string('industry_location_map');
            $table->text('location_address');
            $table->unsignedBigInteger('pradeshiya_sabha');
            $table->string('approval_industrial_zone')->nullable();
            $table->float('local_amount', 8, 2);
            $table->float('foreign_amount', 8, 2)->nullable();
            $table->string('commencement_date')->nullable();
            $table->string('number_of_shifts')->nullable();
            $table->string('number_of_workers')->nullable();
            $table->text('permits')->nullable();
            $table->string('within5km')->nullable();
            $table->text('other5km')->nullable();
            $table->text('list_existing_industries')->nullable();
            $table->text('land_for_treatment_plant')->nullable();
            $table->text('manufacturing_products')->nullable();
            $table->text('by_products_list')->nullable();
            $table->text('process_description')->nullable();
            $table->string('process_flow_diagram')->nullable();
            $table->text('raw_materials')->nullable();
            $table->text('chemicals')->nullable();
            $table->text('precautionary_measures')->nullable();
            $table->text('storage_facilities')->nullable();
            $table->text('fire_equipment_details')->nullable();
            $table->float('processing_requirement', 8, 2)->nullable();
            $table->float('cooling_requirement', 8, 2)->nullable();
            $table->float('washing_requirement', 8, 2)->nullable();
            $table->float('domestic_requirement', 8, 2)->nullable();
            $table->string('waterSource')->nullable();
            $table->float('daily_tot_discharge', 8, 2)->nullable();
            $table->string('waterDischargeMethod')->nullable();
            $table->string('waterDischargeFinalPoint')->nullable();
            $table->text('discharge_toxics_substances')->nullable();
            $table->string('water_treatment_process')->nullable();
            $table->string('characteristics_of_water')->nullable();
            $table->string('water_recycling')->nullable();
            $table->string('solid_waste_type')->nullable();
            $table->float('solid_waste_quantity', 8, 2)->nullable();
            $table->string('disposalMethods')->nullable();
            $table->string('nitrogen')->nullable();
            $table->string('sulphur')->nullable();
            $table->string('dust')->nullable();
            $table->string('other_emissions')->nullable();
            $table->float('number_of_chimneys', 8, 2)->nullable();
            $table->float('chimney_height', 8, 2)->nullable();
            $table->text('odour_abatement')->nullable();
            $table->text('noise_abatement')->nullable();
            $table->float('tot_inplant_gen', 8, 2)->nullable();
            $table->float('tot_public_supply', 8, 2)->nullable();
            $table->string('machine_type')->nullable();
            $table->string('fuel_use')->nullable();
            $table->float('machine_units', 8, 2)->nullable();
            $table->string('machine_horse_power')->nullable();
            $table->string('fuel_daily_consumption')->nullable();
            $table->text('recycling')->nullable();
            $table->text('plan_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_new_epls');
    }
}
