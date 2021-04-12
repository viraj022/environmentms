<?php

namespace App;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;

class inspection_recommendation extends Model
{

    public function InspectionSession()
    {
        return $this->belongsTo(InspectionSession::class);
    }
}
