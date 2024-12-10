<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public const APPLICATIONFEE = 'Application Fee';
    public const INSPECTIONFEE = 'Inspection Fee';
    public const LICENCE_FEE = 'Licence Fee';
    public const EIA = 'EIA Processing fee';
    public const IEE = 'IEE Processing Fee';
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
