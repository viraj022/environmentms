<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'contact',
        'nic',
        'address',
        'invoice_number',
        'payment_method',
        'payment_reference_number',
        'cheque_issue_date',
        'user_id',
        'amount',
        'invoice_date',
        'remark',
        'status',
        'sub_total',
        'vat_amount',
        'nbt_amount',
        'other_tax_amount',
        'canceled_at',
        'canceled_by',
    ];

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
