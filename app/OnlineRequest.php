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
    public function onlineNewApplicationRequest()
    {
        return $this->hasOne(OnlineNewApplicationRequest::class);
    }

    public function applicationRequest()
    {
        if ($this->request_type == 'renewal') {
            // search for renewal request
            return OnlineRenewalApplicationRequest::where('id', $this->online_request_id)->firstOrFail();
        } elseif ($this->request_type == 'new') {
            // search for new application request
            return OnlineNewApplicationRequest::where('id', $this->online_request_id)->firstOrFail();
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

    /**
     * Online request has many online tree felling application requests
     *
     * @return HasMany
     */
    public function onlineTreeFellingRequests()
    {
        return $this->hasMany(TreeFelling::class);
    }

    /**
     * Online request has many online state land lease application requests
     *
     * @return HasMany
     */
    public function onlineStateLandLeaseRequests()
    {
        return $this->hasMany(StateLandLease::class);
    }

    /**
     * Online request has many online refiling paddy land application requests
     *
     * @return HasMany
     */
    public function onlineRefilingPaddyLandRequests()
    {
        return $this->hasMany(RefilingPaddyLand::class);
    }

    /**
     * Online request has many online telecommunication tower application requests
     *
     * @return HasMany
     */
    public function onlineTelecommunicationTowerRequests()
    {
        return $this->hasMany(TelecommunicationTower::class);
    }

    /**
     * Online request has many online waste management application requests
     *
     * @return HasMany
     */
    public function onlineWasteManagementRequests()
    {
        return $this->hasMany(WasteManagement::class);
    }

    /**
     * Online request has many online site clearance application requests
     *
     * @return HasMany
     */
    public function onlineSiteClearanceRequests()
    {
        return $this->hasMany(OnlineSiteClearance::class);
    }

    /**
     * Online request has many online renewal epl application requests
     *
     * @return HasMany
     */
    public function onlineRenewalEplRequests()
    {
        return $this->hasMany(OnlineRenewalEpl::class);
    }

    /**
     * Online request has many online new epl application requests
     *
     * @return HasMany
     */
    public function onlineNewEplRequests()
    {
        return $this->hasMany(OnlineNewEpl::class);
    }
}
