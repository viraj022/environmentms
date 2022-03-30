<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'is_read', 'user_id', 'client_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
