<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\OnlineNewApplicationRequest;
use App\OnlineRenewalApplicationRequest;

class OnlineRequest extends Model
{
    use SoftDeletes;

    public const RENEWAL = 'renewal';
    public const NEW = 'new';
    public const PAYMENT = 'payment';

    protected $fillable = [
        'request_type', 'status', 'request_id', 'request_model',
    ];

    /**
     * Online request has many renewal applications
     *
     * @return HasMany
     */
    public function onlineRenewalApplicationRequests()
    {
        return $this->hasMany(OnlineRenewalApplicationRequest::class);
    }

    /**
     * Online request haqs many online new application requests
     *
     * @return HasMany
     */
    public function onlineNewApplicationRequests()
    {
        return $this->hasMany(OnlineNewApplicationRequest::class);
    }

    public function applicationRequest()
    {
        if ($this->request_type == 'renewal') {
            // search for renewal request
            return OnlineRenewalApplicationRequest::where('id', $this->request_id)->firstOrFail();
        } elseif ($this->request_type == 'new') {
            // search for new application request
            return OnlineNewApplicationRequest::where('id', $this->request_id)->firstOrFail();
        } elseif ($this->request_type == 'payment') {
            return Transaction::whereId($this->request_id)
                ->with(
                    'client',
                    'client.industryCategory',
                    'client.businessScale',
                    'client.pradesheeyasaba',
                    'transactionItems',
                    'transactionItems.payment',
                    'transactionItems.paymentType'
                )
                ->firstOrFail();
        }
    }
}
