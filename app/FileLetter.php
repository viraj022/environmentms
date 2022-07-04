<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileLetter extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','client_id','letter_title','letter_content', 'letter_status'];
}
