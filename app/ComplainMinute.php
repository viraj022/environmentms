<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainMinute extends Model
{
    public function complain()
    {
        return $this->belongsTo(Complain::class);
    }
}
