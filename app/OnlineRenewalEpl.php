<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineRenewalEpl extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'industry_name',
        'industry_address',
        'applicant_name',
        'applicant_address',
        'applicant_nic',
        'applicant_telephone',
        'applicant_email',
        'pradeshiya_sabha',
        'epl_number',
        'epl_issued', 
        'epl_expired',
        'changes_after_last_epl',
        'production_changes',
        'other_department_report',
        'other_details',
    ];
}
