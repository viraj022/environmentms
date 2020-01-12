<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    public const CONDITION_GOOD = "Good";
    public const CONDITION_MODERATE = "Moderate";
    public const CONDITION_BAD = "Bad";

    public const CATEGORY_DUMP = "Dump";
    public const CATEGORY_TRANSFER = "Transfer";
    public const CATEGORY_DUMP_TRANSFER = "Dump_Transfer";

    public const OWNER_LA = "LA";
    public const OWNER_PRIVATE = "Private";
    public const OWNER_LA_PRIVATE = "LA_Private";
    use SoftDeletes;

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);

    }
}
