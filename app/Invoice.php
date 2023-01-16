<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'payment_method',
        'cheque_number',
        'user_id',
        'amount',
        'invoice_date',
        'remark'
    ];

    public function transactions()
    {
        return $this->hasMany(transactions::class);
    }
}
