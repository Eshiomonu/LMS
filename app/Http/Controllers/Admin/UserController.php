<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('enrollments')->latest();

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) {
            $query->where(fn($q) => $q
                ->where('name',  'like', '%'.$request->search.'%')
                ->orWhere('email','like', '%'.$request->search.'%')
            );
        }

        $users = $query->paginate(20)->withQueryString();

        $stats = [
            'total'     => User::count(),
            'approved'  => User::where('status','approved')->count(),
            'pending'   => User::where('status','pending')->count(),
            'suspended' => User::where('status','suspended')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function show(User $user)
    {
        $user->load(['enrollments.course']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone'  => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'in:pending,approved,rejected,suspended'],
        ]);
        $user->update($data);
        return back()->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User removed.');
    }

    public function suspend(User $user)
    {
        $user->update(['status' => 'suspended', 'is_active' => false]);
        return back()->with('success', $user->name . ' has been suspended.');
    }

    public function activate(User $user)
    {
        $user->update(['status' => 'approved', 'is_active' => true]);
        return back()->with('success', $user->name . ' has been activated.');
    }

    public function approve(User $user)
    {
        $user->update([
            'status'      => 'approved',
            'is_active'   => true,
            'approved_at' => now(),
            'approved_by' => auth('admin')->id(),
        ]);
        return back()->with('success', $user->name . ' approved.');
    }

    public function reject(Request $request, User $user)
    {
        $request->validate(['rejection_reason' => ['nullable', 'string']]);
        $user->update([
            'status'           => 'rejected',
            'is_active'        => false,
            'rejection_reason' => $request->rejection_reason,
        ]);
        return back()->with('success', $user->name . ' rejected.');
    }
}