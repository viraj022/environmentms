<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionSession extends Model
{
    use SoftDeletes;

    public const TYPE_EPL = 'EPL';
    public const SITE_CLEARANCE = 'Site Clearance';

    public function inspectionRemarks()
    {
        return $this->hasMany(InspectionRemarks::class);
    }
    public function inspectionSessionAttachments()
    {
        return $this->hasMany(InspectionSessionAttachment::class);
    }
    public function inspectionPersonals()
    {
        return $this->hasMany(InspectionPersonal::class);
    }

    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
