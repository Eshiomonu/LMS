<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // ──────────────────────────────────────────────────────────
    // GET /courses
    // ──────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Course::published()->with('category');

        // Full-text search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('subtitle', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) =>
                $q->where('slug', $request->category)
            );
        }

        // Level filter
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Price filter
        match ($request->price) {
            'free' => $query->where('price', 0),
            'paid' => $query->where('price', '>', 0),
            default => null,
        };

        $courses    = $query->latest('published_at')->paginate(12)->withQueryString();
        $categories = Category::active()->withCount('courses')->get();

        return view('courses.index', compact('courses', 'categories'));
    }

    // ──────────────────────────────────────────────────────────
    // GET /courses/{slug}
    // ──────────────────────────────────────────────────────────

    public function show(string $slug)
    {
        $course = Course::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        // Related courses in same category
        $related = Course::published()
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->take(3)
            ->get();

        // Check existing enrollment for logged-in user
        $enrollment = null;
        if (Auth::check()) {
            $enrollment = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->first();
        }

        return view('courses.show', compact('course', 'related', 'enrollment'));
    }

    // ──────────────────────────────────────────────────────────
    // POST /courses/{slug}/enroll
    // ──────────────────────────────────────────────────────────

    public function enroll(Request $request, string $slug)
    {
        $course = Course::published()->where('slug', $slug)->firstOrFail();
        $user   = Auth::user();

        // Guard: already enrolled
        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return redirect()->route('courses.show', $slug)
                ->with('info', 'You have already applied for this course. Status: ' . ucfirst($existing->status));
        }

        // Validate enrollment form
        $request->validate([
            'motivation'       => ['required', 'string', 'min:20', 'max:1000'],
            'experience'       => ['required', 'string', 'max:500'],
            'goals'            => ['required', 'string', 'max:500'],
            'phone'            => ['required', 'string', 'max:20'],
            'how_did_you_hear' => ['nullable', 'string', 'max:100'],
            'company'          => ['nullable', 'string', 'max:255'],
            'job_title'        => ['nullable', 'string', 'max:255'],
        ]);

        // Update user phone if not set
        if (! $user->phone) {
            $user->update(['phone' => $request->phone]);
        }

        // Create enrollment
        Enrollment::create([
            'user_id'         => $user->id,
            'course_id'       => $course->id,
            'status'          => 'pending',
            'enrollment_form' => [
                'motivation'       => $request->motivation,
                'experience'       => $request->experience,
                'goals'            => $request->goals,
                'phone'            => $request->phone,
                'how_did_you_hear' => $request->how_did_you_hear,
                'company'          => $request->company,
                'job_title'        => $request->job_title,
            ],
            'payment_status' => 'pending',
            'amount_paid'    => $course->effective_price,
            'currency'       => $course->currency ?? 'NGN',
            'enrolled_at'    => now(),
        ]);

        return redirect()->route('courses.show', $slug)
            ->with('success', 'Application submitted! Our team will review and contact you within 24 hours.');
    }
}