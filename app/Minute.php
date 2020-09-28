<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fileTye()
    {
        return $this->belongsTo(User::class);
    }
}
