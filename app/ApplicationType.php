<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    public function attachemnts()
    {
        return $this->belongsToMany(Attachemnt::class);
    }
}
