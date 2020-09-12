<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use SoftDeletes;
    
    public function client()
    {
            return $this->belongsTo(Client::class);
    }
}
