<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocalAuthority extends Model
{
    use SoftDeletes;
    public const MUNICIPAL = 'Municipal Council';
    public const URBAN = 'Urban Council';
    public const PRADESHIYA = 'Pradeshiya Sabha';
    public const MEGA = 'Mega Police';

    public function ProvincialCouncil()
    {
        return $this->belongsTo(ProvincialCouncil::class);
    }
    public static function all($columns = ['*'])
    {
        return LocalAuthority::where('parent_id', null)->get();
    }
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
