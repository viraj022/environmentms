<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreeFelling extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'nic',
        'telephone',
        'email',
        'number_of_trees',
        'land_ownership_type',
        'extent_of_land',
        'deed_number',
        'survey_plan_number',
        'address_of_land',
        'trees_already_felt',
        'pradeshiya_sabha',
        'division_secretariat',
        'current_land_use',
        'land_pattern_within_100m',
        'tree_felling_reason',
        'rehabilitation_plan',
        'deed_of_land',
        'survey_plan',
        'landowners_affidavit',
    ];
}
