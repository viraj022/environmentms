<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainMinute extends Model
{
    public function complain()
    {
        return $this->belongsTo(Complain::class);
    }

    public function minuteUser()
    {
        return $this->belongsTo(User::class, 'minute_user_id');
    }
}
