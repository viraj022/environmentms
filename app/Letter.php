<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'letter_title', 'letter_content', 'status', 'complain_id', 'user_name',
    ];

    public function complain()
    {
        return $this->belongsTo(Complain::class);
    }
}
