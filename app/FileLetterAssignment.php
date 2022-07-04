<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileLetterAssignment extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','letter_id','assigned_by_id','assigned_to_id'];
}
