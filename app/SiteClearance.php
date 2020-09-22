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

    protected $fillable = ['client_id', 'remark', 'site_clearance_type'];
}
