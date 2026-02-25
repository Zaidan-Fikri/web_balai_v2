<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('admin_user_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
