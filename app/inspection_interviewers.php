<?php

namespace App;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class inspection_interviewers extends Model
{
    use SoftDeletes;
    
    public function InspectionSession() {
        return $this->belongsTo(InspectionSession::class);
    }
}
