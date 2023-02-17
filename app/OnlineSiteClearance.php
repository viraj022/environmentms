<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineSiteClearance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'industry_name',
        'sc_type',
        'old_sc_number',
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
        'contact_person_email',
        'nic',
        'building_layout_plan',
        'local_amount',
        'foreign_amount',
        'commencement_date',
        'number_of_shifts',
        'number_of_workers',
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
        'water_discharge_final_point',
        'solid_waste_type',
        'solid_waste_quantity',
        'nitrogen',
        'sulphur',
        'dust',
        'other_emissions',
        'noise_abatement',
        'odour_abatement',
        'tot_inplant_gen',
        'tot_public_supply',
        'fuel_type',
        'fuel_use',
        'fuel_daily_consumption',
        'recycling',
        'plan_description',
        'developing_land_area',
        'land_ownership_type',
        'within_buffer_zone_m',
        'w_discharge_method',
        'solid_disposal',
        'tot_other_supply',
        'machines',
        'chimney',
        'air_emission_report',
        'old_sc_cer',
        'building_plan',
        'deed_of_land',
        'survey_plan',
        'business_reg_cer',
        'project_report',
        'tot_discharge_per_day',
        'contaminants',
        'refinery_waste_water',
        'industryDetailCheck',
        'other_ind_type'
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
