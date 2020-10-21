<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function __construct() {
        $this->middleware(['auth']);
    }

    public function index() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return view('dashboard', ['pageAuth' => $pageAuth]);
    }

}
