<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileLetter extends Model
{
    use SoftDeletes;

    protected $fillable = ['id', 'client_id', 'letter_title', 'letter_content', 'letter_status'];

    public function fileLetterMinutes()
    {
        return $this->hasMany(FileLetterMinute::class, 'letter_id', 'id');
    }

    public function fileLetterAssignments()
    {
        return $this->hasMany(FileLetterAssignment::class, 'letter_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
