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

    public function paymentRanges()
    {
        return $this->hasMany(PaymentRange::class, 'payments_id', 'id');
    }

    public static function getPaymentByName($name)
    {
        return Payment::where('name', $name)->first();
    }
}
