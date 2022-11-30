<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pradesheeyasaba extends Model
{
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function complains()
    {
        return $this->hasMany(Complain::class);
    }
}
