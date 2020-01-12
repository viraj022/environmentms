<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SamapthKendraya extends Model
{
    use SoftDeletes;
    public function localAuthority()
    {
        return $this->belongsTo(LocalAuthority::class);
    }
}
