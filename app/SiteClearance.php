<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteClearance extends Model
{
    use SoftDeletes;
    public const SITE_CLEARANCE = 'Site Clearance';
    public const SITE_TELECOMMUNICATION = 'Telecommunication';
    public const SITE_SCHEDULE_WASTE = 'Schedule Waste';
    public const EIA_POSS_FEE = 'EIA Processing Fee';
    public const IEE_POSS_FEE = 'IEE Processing Fee';

    public function siteClearenceSession()
    {
        return $this->belongsTo(SiteClearenceSession::class);
    }
}
