<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineRequestStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'online_request_id',
        'status',
        'user_id'
    ];

    public function onlineRequest()
    {
        return $this->belongsTo(OnlineRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
