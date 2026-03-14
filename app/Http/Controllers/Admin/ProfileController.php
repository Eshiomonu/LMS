<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = auth('admin')->user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = auth('admin')->user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:admins,email,' . $admin->id],
        ]);

        $admin->update($data);
        return back()->with('success', 'Profile updated successfully.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $admin = auth('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully.');
    }
}