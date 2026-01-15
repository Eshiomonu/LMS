<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Homepage
    public function home()
    {
        $featuredCourses = Course::take(6)->get(); // 6 featured courses
        return view('pages.home', compact('featuredCourses'));
    }

    // All courses
    public function index()
    {
        $courses = Course::paginate(12);
        return view('courses.index', compact('courses'));
    }

    // Single course
    public function show($id)
    {
        $course = Course::findOrFail($id); // throws 404 if not found
        return view('courses.show', compact('course'));
    }

    // Enroll into course
    public function enroll($id)
    {
        $course = Course::findOrFail($id);

        $user = Auth::user();
        // Logic to enroll the user (e.g., create a pivot table entry)
        $user->courses()->syncWithoutDetaching([$course->id]);

        return redirect()->route('courses.show', $course->id)
                         ->with('success', 'Enrolled successfully!');
    }
}
