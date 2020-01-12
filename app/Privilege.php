<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    public $timestamps = false;
    public function rolls()
    {
        return $this->belongsToMany(Roll::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
