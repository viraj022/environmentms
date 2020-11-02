<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileLog extends Model
{
    protected $fillable = [
        'client_id', 'code', 'description', 'auth_level', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
