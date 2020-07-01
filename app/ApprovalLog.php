<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalLog extends Model
{
    public const Type_EPL = 'EPL';
    public const Type_SITE_CLEARANCE = 'site_clearance';

    public const OFF_DIRECTOR = "director";
    public const OFF_A_DIRECTOR = "a_director";
    public const OFF_OFFICER = "officer";

    public const APP_APPROVE = 0;
    public const APP_REJECT = 1;
}
