<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileLetterMinute extends Model
{
    use SoftDeletes;

    protected $fillable = ['id', 'letter_id', 'user_id', 'description'];

    public function fileLetter()
    {
        return $this->belongsTo(FileLetter::class, 'letter_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
