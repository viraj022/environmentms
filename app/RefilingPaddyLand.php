<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefilingPaddyLand extends Model
{
    protected $fillable = [
        'name',
        'address',
        'nic',
        'telephone',
        'email',
        'pradeshiya_sabha',
        'division_secretariat',
        'gs_division',
        'agrarian_service_division',
        'paddy_land_owner_name',
        'deed_number',
        'survey_plan_number',
        'extent_of_land',
        'utility_of_land',
        'utility_of_bounded_land',
        'proposed_land_utility',
        'reason',
        'route_map',
        'deed_of_land',
        'survey_plan',
        'add_issue_letter',
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
