<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suboffice extends Model
{
    use SoftDeletes;
    public const SUBOFFICE = 'Suboffice';
    protected $table = 'local_authorities';
    public static function all($columns = ['*'])
    {
        return LocalAuthority::where('parent_id', '!=', null)->get();
    }
}
