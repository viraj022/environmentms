<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProvincialCouncil extends Model
{
    protected $fillable = [''];
       public function localAuthority()
    {
//        if($this)
        return $this->hasMany(LocalAuthority::class);
    }
}
