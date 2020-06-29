<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
