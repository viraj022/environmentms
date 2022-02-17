<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAssignedComplain extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function complain(){
        return $this->belongsTo(Complain::class);
    }

    protected $fillable = [
        'complain_id', 'user_id', 'assigned_time'
    ];

}
