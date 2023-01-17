<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'nic',
        'invoice_number',
        'payment_method',
        'payment_reference_number',
        'user_id',
        'amount',
        'invoice_date',
        'remark',
        'status'
    ];

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
