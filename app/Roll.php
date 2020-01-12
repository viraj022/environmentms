<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{

    protected $fillable = ['name', 'level_id'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function privileges()
    {
        return  $this->belongsToMany(Privilege::class)->withPivot('is_read', 'is_create','is_update','is_delete');;
    }

}
