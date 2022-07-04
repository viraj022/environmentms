<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileLetterMinute extends Model
{
    use SoftDeletes;

    protected $fillable = ['id', 'letter_id', 'user_id', 'description'];
}
