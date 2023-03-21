<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarningLetter extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_id', 'expired_days', 'file_type', 'expire_date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
