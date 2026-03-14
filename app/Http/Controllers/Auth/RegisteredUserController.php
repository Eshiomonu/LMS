<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    // GET /register
    public function create()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('student.dashboard');
        }
        return view('auth.register');
    }

    // POST /register
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone'    => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone'     => $request->phone,
            'role'      => 'student',
            'status'    => 'approved',
            'is_active' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect back to the course page if they came from one
        $redirectTo = $request->input('redirect_to');
        if ($redirectTo && str_starts_with($redirectTo, url('/'))) {
            return redirect($redirectTo);
        }

        return redirect()->route('student.dashboard');
    }
}