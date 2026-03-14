<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    // GET /login
    public function create()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('student.dashboard');
        }
        return view('auth.login');
    }

    // POST /login
    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();

        // Block suspended accounts immediately
        if (! $user->is_active || $user->status === 'suspended') {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Your account has been suspended. Please contact support.',
            ]);
        }

        $request->session()->regenerate();

        // Redirect back to the course page if they came from one
        $redirectTo = $request->input('redirect_to');
        if ($redirectTo && str_starts_with($redirectTo, url('/'))) {
            return redirect($redirectTo);
        }

        return redirect()->intended(route('student.dashboard'));
    }

    // POST /logout
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}