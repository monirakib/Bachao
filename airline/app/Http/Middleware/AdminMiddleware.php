<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type === 'Admin') {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
    }
}