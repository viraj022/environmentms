<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachemnt extends Model
{
    public function applicationTypes()
    {
        return $this->belongsToMany(ApplicationType::class);
    }

    public function epls()
    {
        return  $this->belongsToMany(EPL::class);
    }
}
