<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineRenewalApplicationRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'online_request_id',
        'renewal_type',
        'certificate_number',
        'person_name',
        'industry_name',
        'business_registration_no',
        'contact_no',
        'mobile_no',
        'email',
        'attachment_file',
        'status',
        'client_id',
    ];

    public function onlineRequest()
    {
        return $this->belongsTo(OnlineRequest::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
