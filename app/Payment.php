<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const INSPECTION = 73;
    public function paymentTypes()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function PaymentRanges()
    {
        return $this->hasMany(PaymentRange::class);
    }
}
