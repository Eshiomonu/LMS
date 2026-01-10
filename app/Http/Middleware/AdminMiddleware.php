<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Not logged in
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        // Logged in but not admin
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
