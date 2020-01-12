<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plant extends Model
{
    use SoftDeletes;
    public const BIO = 'Bio Plant';
    public const COMPOST = 'Compost Palnt';

    public function localAuthority()
    {
                return $this->belongsTo(LocalAuthority::class);
    }
}
