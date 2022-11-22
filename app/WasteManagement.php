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
    ];
}
