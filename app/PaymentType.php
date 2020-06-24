<?php

namespace App;

use Faker\Provider\ar_SA\Payment;
use Illuminate\Database\Eloquent\Model;
use App\PaymentType;

class PaymentType extends Model
{
    public const APPLICATIONFEE = 'Application Fee';
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public static function getpaymentByTypeName($name){
        return PaymentType::where('name',$name)->first();
    }
}
