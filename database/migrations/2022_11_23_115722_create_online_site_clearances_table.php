<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineSiteClearancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_site_clearances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('industry_name');
            $table->string('industry_type');
            $table->string('other_industry_type')->nullable();
            $table->string('industry_location');
            $table->unsignedBigInteger('pradeshiya_sabha');
            $table->string('divisional_secretariat_division');
            $table->string('approval_industrial_zone')->nullable();
            $table->string('applicant_name');
            $table->text('applicant_address');
            $table->string('applicant_number');
            $table->string('contact_person_name');
            $table->string('contact_person_designation');
            $table->text('contact_person_address');
            $table->string('contact_person_number');
            $table->string('building_layout_plan')->nullable();
            $table->decimal('local_amount', 10, 2)->default(0.00);
            $table->decimal('foreign_amount', 10, 2)->nullable();
            $table->date('commencement_date')->nullable();
            $table->string('number_of_shifts')->nullable();
            $table->string('number_of_workers')->nullable();
            $table->string('within5km')->nullable();
            $table->text('list_existing_industries')->nullable();
            $table->string('land_use_pattern')->nullable();
            $table->text('manufacturing_products')->nullable();
            $table->text('products_list')->nullable();
            $table->string('process_flow_diagram')->nullable();
            $table->text('raw_materials')->nullable();
            $table->float('processing_requirement', 10, 2)->nullable();
            $table->float('cooling_requirement', 10, 2)->nullable();
            $table->float('washing_requirement')->nullable();
            $table->float('demestic_requirement')->nullable();
            $table->string('waterSource')->nullable();
            $table->string('daily_tot_discharge')->nullable();
            $table->string('waterDischargeMethod')->nullable();
            $table->string('water_discharge_final_point')->nullable();
            $table->text('discharge_toxics_substances')->nullable();
            $table->text('water_treatment_process')->nullable();
            $table->text('characteristics_of_water')->nullable();
            $table->text('water_recycling')->nullable();
            $table->string('solid_waste_type')->nullable();
            $table->string('solid_waste_quantity')->nullable();
            $table->string('disposalMethods')->nullable();
            $table->string('nitrogen')->nullable();
            $table->string('sulphur')->nullable();
            $table->string('dust')->nullable();
            $table->string('other_emissions')->nullable();
            $table->string('number_of_chimneys')->nullable();
            $table->float('chimney_height', 10, 2)->nullable();
            $table->text('noise_abatement')->nullable();
            $table->float('tot_inplant_gen', 10, 2)->nullable();
            $table->float('tot_public_supply', 10, 2)->nullable();
            $table->string('machine_type')->nullable();
            $table->string('machine_horse_power')->nullable();
            $table->float('machine_units', 10, 2)->nullable();
            $table->string('fuel_use')->nullable();
            $table->string('fuel_daily_consumption')->nullable();
            $table->text('recycling')->nullable();
            $table->text('plan_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_site_clearances');
    }
}
