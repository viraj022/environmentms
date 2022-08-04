<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineNewApplicationRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'online_request_id',
        'title',
        'firstname',
        'lastname',
        'address',
        'mobile_number',
        'email_address',
        'nic_number',
        'pradesheeyasaba_id',
        'industry_category_id',
        'business_scale',
        'industry_sub_category',
        'business_registration_number',
        'business_name',
        'is_in_industry_zone',
        'investment_amount',
        'industry_address',
        'start_date',
        'submitted_date',
        'industry_contact_no',
        'industry_email_address',
        'client_id',
        'status',
    ];

    public function onlineRequest()
    {
        return $this->belongsTo(OnlineRequest::class);
    }

    public function pradeshiyaSabha()
    {
        return $this->belongsTo(Pradesheeyasaba::class, 'pradesheeyasaba_id');
    }

    public function industryCategory()
    {
        return $this->belongsTo(IndustryCategory::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
