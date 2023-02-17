<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineNewEpl extends Model
{
    protected $fillable = [
        'industry_name',
        'industry_type',
        'nic',
        'industry_br',
        'industry_nature',
        'industry_GPS',
        'telephone_Number',
        'applicant_name',
        'applicant_address',
        'applicant_telephone',
        'industry_location_map',
        'location_address',
        'pradeshiya_sabha',
        'approval_industrial_zone',
        'industrial_zone2',
        'industrial_zone3',
        'industrial_zone4',
        'industrial_zone5',
        'land_amount',
        'buildings_amount',
        'machinery_amount',
        'commencement_date',
        'number_of_shifts',
        'number_of_workers',
        'permits',
        'within5km',
        'other5km',
        'list_existing_industries',
        'land_for_treatment_plant',
        'manufacturing_products',
        'by_products_list',
        'process_description',
        'process_flow_diagram',
        'raw_materials',
        'chemicals',
        'precautionary_measures',
        'storage_facilities',
        'fire_equipment_details',
        'processing_requirement',
        'cooling_requirement',
        'washing_requirement',
        'domestic_requirement',
        'waterSource',
        'daily_tot_discharge',
        'waterDischargeMethod',
        'waterDischargeFinalPoint',
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
        'odour_abatement',
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
