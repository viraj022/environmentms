<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentRange extends Model
{
    public function Payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
