<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectionPersonal extends Model
{
    protected $fillable = [
        'inspection_session_id',
        'name',
    ];
    public function InspectionSession()
    {
        return $this->belongsTo(InspectionSession::class);
    }
}
