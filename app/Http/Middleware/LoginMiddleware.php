<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard("t_manager")->check()) {
            return redirect()->route('team.manager.profile');
        }
        else if(Auth::guard('c_manager')->check()) {
            return redirect()->route('home');
        }
        else if (Auth::guard('web')->check()) {
            return redirect()->route('player.profile');
        }

        return $next($request);
    }
}
