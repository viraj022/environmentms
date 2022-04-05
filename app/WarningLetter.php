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
        'letter_generated_date', 'user_id', 'client_id', 'expired_days',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
