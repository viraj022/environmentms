<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StateLandLease extends Model
{
    protected $fillable = [
        'name',
        'address',
        'nic',
        'telephone',
        'email',
        'extent_of_land',
        'survey_plan_number',
        'pradeshiya_sabha',
        'utility_of_land',
        'purpose',
        'sensitive_area_100m',
        'lessor_letter',
        'survey_plan',
        'route_map',
    ];
}
