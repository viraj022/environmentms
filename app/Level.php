<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Array_;

class Level extends Model
{
    public const NATIONAL = 'National';
    public const PROVINCIAL = 'Provincial';
    public const LOCAL = 'Local';

    protected $fillable = ['name', 'value'];

    public function rolls()
    {
        return $this->hasMany(Roll::class, 'level_id');
    }

    public function institutes()
    {
        $level = $this->name;
        if ($level === Level::PROVINCIAL) {
            return ProvincialCouncil::all();
        } else if ($level === Level::LOCAL) {
            return LocalAuthority::all();
        }else if($level === Level::NATIONAL){
            return array(array('id'=>-99,'name'=>'National'));
        }
    }
}
