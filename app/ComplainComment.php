<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainComment extends Model
{
    public function complain()
    {
        return $this->belongsTo(Complain::class);
    }

    protected $fillable = [
        'comment', 'complain_id ', 'commented_user_id'
    ];

    public function commentedUser()
    {
        return $this->belongsTo(User::class, 'commented_user_id');
    }
}
