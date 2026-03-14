<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('student.profile.edit');
    }

    // PUT /dashboard/profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'  => ['nullable', 'string', 'max:20'],
            'bio'    => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio'   => $request->bio,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if stored locally
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('student.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    // PUT /dashboard/profile/password
    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('student.profile.edit')
            ->with('success', 'Password updated successfully.');
    }
}