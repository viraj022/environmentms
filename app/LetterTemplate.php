<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LetterTemplate extends Model
{
    protected $fillable = [
        'template_name', 'content', 'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
