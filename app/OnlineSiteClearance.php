<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineSiteClearance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'industry_name',
        'industry_type',
        'other_industry_type',
        'industry_address',
        'industry_location',
        'pradeshiya_sabha',
        'divisional_secretariat_division',
        'approval_industrial_zone',
        'applicant_name',
        'applicant_address',
        'applicant_number',
        'contact_person_name',
        'contact_person_designation',
        'contact_person_address',
        'contact_person_number',
        'building_layout_plan',
        'local_amount',
        'foreign_amount',
        'commencement_date',
        'number_of_shifts',
        'number_of_workers',
        'within5km',
        'list_existing_industries',
        'land_use_pattern',
        'manufacturing_products',
        'products_list',
        'process_flow_diagram',
        'raw_materials',
        'processing_requirement',
        'cooling_requirement',
        'washing_requirement',
        'demestic_requirement',
        'waterSource',
        'daily_tot_discharge',
        'waterDischargeMethod',
        'water_discharge_final_point',
        'discharge_toxics_substances',
        'water_treatment_process',
        'characteristics_of_water',
        'water_recycling',
        'solid_waste_type',
        'solid_waste_quantity',
        'disposalMethods',
        'nitrogen',
        'sulphur',
        'dust',
        'other_emissions',
        'number_of_chimneys',
        'chimney_height',
        'noise_abatement',
        'tot_inplant_gen',
        'tot_public_supply',
        'machine_type',
        'machine_horse_power',
        'machine_units',
        'fuel_use',
        'fuel_daily_consumption',
        'recycling',
        'plan_description',
    ];

    public function onlineRequest()
    {
        return $this->belongsTo(OnlineRequest::class);
    }

    public function pradeshiyaSabha()
    {
        return $this->belongsTo(Pradesheeyasaba::class, 'pradeshiya_sabha');
    }
}
