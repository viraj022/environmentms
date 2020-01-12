<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckNational
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $aUser = Auth::user();
        if ($aUser->office() == User::NATIONAL) {
            return $next($request);
        } else {
            return abort(403);
        }

    }
}
