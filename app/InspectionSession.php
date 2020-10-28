<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class InspectionSession extends Model
{
    use SoftDeletes;

    public const TYPE_EPL = 'EPL';
    public const SITE_CLEARANCE = 'Site Clearance';
    protected $appends = ['schedule_date_only'];

    protected $casts = [
        'completed_at' => 'datetime:Y-m-d',
    ];
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

    public function getScheduleDateOnlyAttribute()
    {
        //return strtotime($this->schedule_date)->toDateString();
        return Carbon::parse($this->schedule_date)->format('Y-m-d');
    }
}
