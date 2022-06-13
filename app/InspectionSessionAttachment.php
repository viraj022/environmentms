<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectionSessionAttachment extends Model
{
    protected $fillable = [
        'inspection_session_id',
        'path',
        'type',
    ];
    public function InspectionSession()
    {
        return $this->belongsTo(InspectionSession::class);
    }
}
