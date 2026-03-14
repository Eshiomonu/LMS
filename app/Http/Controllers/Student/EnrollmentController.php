<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Auth::user()
            ->enrollments()
            ->with('course.category')
            ->latest()
            ->get();

        return view('student.enrollments.index', compact('enrollments'));
    }

    public function show(Enrollment $enrollment)
    {
        // Make sure student can only see their own enrollments
        abort_if($enrollment->user_id !== Auth::id(), 403);

        $enrollment->load('course.category');

        return view('student.enrollments.show', compact('enrollment'));
    }
}