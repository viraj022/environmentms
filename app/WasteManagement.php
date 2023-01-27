<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WasteManagement extends Model
{
    use SoftDeletes;

    protected $table = 'waste_managements';

    protected $fillable = [
        'facility_name',
        'address',
        'telephone',
        'pradeshiya_sabha',
        'district',
        'province',
        'emergency_name',
        'emergency_number',
        'emergency_phone',
        'emergency_fax',
        'emergency_email',
        'emergency_address',
        'activities',
        'applicant_name',
        'applicant_address',
        'applicant_number',
        'applicant_fax',
        'licence_number',
        'permit_qualifications',
        'insurance',
        'emergency_procedures',
        'accidents_info',
        'workers_health',
        'map',
        'waste_category',
        'waste_handle',
        'detail_operation',
        'disposal_des',
        'site_collecion',
        'proposed_date_frequency',
        'estimate_quatity_to_collect',
        'type_of_parking',
        'mode_of_transpotation',
        'class_type_of_vehicles',
        'registered_number',
        'number_of_vehicles',
        'route_details',
        'emergency_measure',
        'location_of_extend_storage_site',
        'type_of_parking_enviasaged',
        'period_of_time_waste',
        'information_relating_recycling',
        'emergency_measures_adopted',
        'location_of_recovery_facilities',
        'methord_used_in_the_recovery',
        'purpose_of_recycling',
        'emergency_measure_adoped_in_the_events',
        'location_of_the_site_for_disposal',
        'method_of_disposal',
        'description_of_the_treatment_process',
        'information_on_the_after_care',
        'emergency_measures_adopted_site_accident',
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
