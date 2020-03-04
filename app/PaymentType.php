<?php

namespace App;

use Faker\Provider\ar_SA\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
