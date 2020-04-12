<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EPL extends Model
{
    use SoftDeletes;
    public const EPL = 'epl';
    public const FINEDATE = '2012-01-01';
    public const INSPECTION = 'inspection';
    public const INSPECTION_FINE = 'inspection_fine';
   

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
