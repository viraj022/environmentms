<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachemnt extends Model
{
    public function applicationTypes()
    {
        return $this->belongsToMany(ApplicationType::class);
    }
}
