<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileLetter extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','client_id','letter_title','letter_content', 'letter_status'];
    
    public function fileLetterMinutes()
    {
        return $this->hasMany(FileLetterMinute::class);
    }

    public function fileLetterAssignments()
    {
        return $this->hasMany(FileLetterAssignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
