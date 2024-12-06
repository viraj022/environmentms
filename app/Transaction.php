<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\TransactionItem;

class Transaction extends Model
{
    use SoftDeletes;

    public const INSPECTION = 'inspection';
    public const LICENCE_FEE = 'licence_fee';
    public const APPLICATION_FEE = 'application_fee';
    public const TRANS_TYPE_EPL = "EPL";
    public const TRANS_TYPE_FINE = "EPL";
    public const TRANS_SITE_CLEARANCE = "Site";
    protected $appends = ['net_total', 'name',  'contact_no',  'nic', 'address', 'industry_name'];
    protected  $fillable = [
        'status',
        'cashier_name',
        'invoice_no',
        'canceled_at',
        'billed_at',
        'type',
        'type_id',
        'client_id',
        'application_client_id',
        'invoice_id',
        'online_payment_id',
    ];

    public function getPaymentDetails()
    {
        $transactionSum = Transaction::where('type', '=', $this->type)
            ->where('transaction_id', '=', $this->transaction_id)->sum('amount');

        $transactionCounterSum = Transactioncounter::where('payment_id', '=', $this->payment_id)
            ->where('type', '=', $this->type)
            ->where('transaction_id', '=', $this->transaction_id)
            ->where('payment_status', '=', 1)
            ->sum('amount');
        return array('amount' => $transactionSum, 'payed' => $transactionCounterSum);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'id');
    }

    public function applicationClient()
    {
        return $this->belongsTo(ApplicationCliten::class, 'application_client_id', 'id');
    }


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getTotal()
    {
        return TransactionItem::where('transaction_id', '=', $this->id)
            ->sum('amount');
    }

    public function getNetTotalAttribute()
    {
        //return strtotime($this->schedule_date)->toDateString();
        return TransactionItem::where('transaction_id', '=', $this->id)
            ->sum('amount');
    }
    public function getNameAttribute()
    {
        if ($this->type == 'application_fee') {
            $data = ApplicationCliten::find($this->type_id);
            return (!empty($data->name)) ? $data->name : "N/A";
        } else {
            $data = Client::find($this->client_id);
            return (!empty($data->first_name)) ? $data->first_name : "N/A";
        }
    }

    public function getIndustryNameAttribute()
    {
        if ($this->type == 'application_fee') {
            $data = ApplicationCliten::find($this->type_id);
            return (!empty($data->name)) ? $data->name : "N/A";
        } else {
            $data = Client::find($this->client_id);
            return (!empty($data->industry_name)) ? $data->industry_name : "N/A";
        }
    }

    public function getContactNoAttribute()
    {
        if ($this->type == 'application_fee') {
            $data = ApplicationCliten::find($this->type_id);
            return (!empty($data->contact_no)) ? $data->contact_no : "N/A";
        } else {
            $data = Client::find($this->client_id);
            return (!empty($data->contact_no)) ? $data->contact_no : "N/A";
        }
    }

    public function getNicAttribute()
    {
        if ($this->type == 'application_fee') {
            $data = ApplicationCliten::find($this->type_id);
            return (!empty($data->nic)) ? $data->nic : "N/A";
        } else {
            $data = Client::find($this->client_id);
            return (!empty($data->nic)) ? $data->nic : "N/A";
        }
    }

    public function getAddressAttribute()
    {
        if ($this->type == 'application_fee') {
            $data = ApplicationCliten::find($this->type_id);
            return (!empty($data->address)) ? $data->address : "N/A";
        } else {
            $data = Client::find($this->client_id);
            return (!empty($data->industry_address)) ? $data->industry_address : "N/A";
        }
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
