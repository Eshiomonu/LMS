<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Block suspended accounts
        if ($user->status === 'suspended' || ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Your account has been suspended. Please contact support.');
        }

        // Block rejected accounts
        if ($user->status === 'rejected') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $reason = $user->rejection_reason
                ? ' Reason: ' . $user->rejection_reason
                : '';

            return redirect()->route('login')
                ->with('error', 'Your account was not approved.' . $reason);
        }

        return $next($request);
    }
}