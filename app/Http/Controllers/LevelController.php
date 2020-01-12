<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;

class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function rollsByLevel($id){
     $level=Level::findOrFail($id);
     return $level->rolls;
    }

    public function instituteById($id){
        $level=Level::findOrFail($id);
        return $level->institutes();
    }
}
