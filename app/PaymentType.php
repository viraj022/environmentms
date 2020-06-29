<?php

namespace App;

use Faker\Provider\ar_SA\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public const APPLICATIONFEE = 'Application Fee';
    public const INSPECTIONFEE = 'Inspection Fee';
    public const LICENCE_FEE = 'Licence Fee';
    public const FINE = 'Fine';
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function getpaymentByTypeName($name)
    {
        return PaymentType::where('name', $name)->first();
    }
}
