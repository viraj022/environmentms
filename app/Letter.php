<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'letter_title', 'letter_content', 'status', 'complain_id'
    ];
}
