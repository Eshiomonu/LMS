<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrollments = $user->enrollments()
            ->with('course.category')
            ->latest()
            ->get();

        $stats = [
            'total_enrolled' => $enrollments->count(),
            'active'         => $enrollments->where('status', 'approved')->count(),
            'pending'        => $enrollments->where('status', 'pending')->count(),
            'completed'      => $enrollments->where('status', 'completed')->count(),
        ];

        $recent = $enrollments->take(5);

        return view('student.dashboard.index', compact('user', 'stats', 'recent'));
    }
}