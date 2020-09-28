<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteClearenceSession extends Model
{
    use SoftDeletes;
    public function siteClearances()
    {
        return $this->hasMany(SiteClearance::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function minutes()
    {
        return $this->hasMany(Minute::class);
    }
}
