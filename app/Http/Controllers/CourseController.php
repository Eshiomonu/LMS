<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;


class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(12); // 12 per page

        return view('courses.index', compact('courses'));
    }
    public function enroll(Course $course)
{
    // User is logged in because of 'auth' middleware
    // Redirect to checkout page (replace with your checkout route)
    return redirect()->route('checkout', ['course' => $course->id])
                     ->with('success', 'You are ready to enroll in ' . $course->title);
}

public function checkout(Course $course)
{
    $user = Auth::user();

    return view('courses.checkout', compact('course', 'user'));
}

public function processCheckout(Request $request, Course $course)
{
    $user = Auth::user();

    // Basic validation for demonstration
    $request->validate([
        'payment_method' => 'required|string|in:card,bank_transfer',
        'agree_terms' => 'accepted',
    ]);

    // Here you would integrate your payment gateway
    // For now, we'll simulate a successful enrollment

    // Example: save enrollment (you can create enrollments table if needed)
    $user->courses()->attach($course->id);

    return redirect()->route('courses.show', $course->id)
                     ->with('success', 'Enrollment successful! Thank you for registering.');
}
}
