<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlinePayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'online_request_id',
        'reference_no',
        'amount',
        'ipg_success_indicator',
        'ipg_result_indicator',
        'ipg_payment_status',
        'paid_at',
        'created_by',
        'status'
    ];

    public function onlineRequest()
    {
        return $this->belongsTo(OnlineRequest::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
