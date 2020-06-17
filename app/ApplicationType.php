<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    public function attachemnts()
    {
        return $this->belongsToMany(Attachemnt::class);
    }

    public static function getByName($name)
    {
        return  ApplicationType::Where('name', $name)->first();
    }
}
