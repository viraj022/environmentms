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

    public function epl()
    {
        return $this->belongsTo(EPL::class, 'epl_id');
    }

    public function siteClearance()
    {
        return $this->belongsTo(SiteClearance::class, 'sc_id');
    }
}
