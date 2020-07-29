<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Array_;

class Level extends Model
{
    public const DIRECTOR = 'Director';
    public const ASSI_DIRECTOR = 'Assistant Director';
    public const ENV_OFFICER = 'Environment Officer';
    public const LOCAL = 'Local';

    protected $fillable = ['name', 'value'];

    public function rolls()
    {
        return $this->hasMany(Roll::class, 'level_id');
    }

    // public function institutes()
    // {
    //     $level = $this->name;
    //     if ($level === Level::DIRECTOR) {
    //         return Zone::all();
    //     } else if ($level === Level::LOCAL) {
    //         return LocalAuthority::all();
    //     } else if ($level === Level::NATIONAL) {
    //         return array(array('id' => -99, 'name' => 'National'));
    //     }
    // }
}
