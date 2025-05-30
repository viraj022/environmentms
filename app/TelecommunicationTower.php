<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelecommunicationTower extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'contact_name',
        'contact_address',
        'contact_number',
        'extent_of_land',
        'land_owner_name',
        'land_owner_address',
        'land_owner_phone',
        'pradeshiya_sabha',
        'land_address',
        'sketch_of_road',
        'investment_amount',
        'tower_height',
        'tower_length',
        'tower_width',
        'power_requirements',
        'des_minimize_lightening',
        'lightening_monitoring',
        'public_places_distance',
        'catastrophic_event',
        'towers_within_500m',
        'nearest_residence_distance',
        'houses_within_50m',
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
