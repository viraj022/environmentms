<?php

namespace App;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;

class inspection_interviewers extends Model
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
