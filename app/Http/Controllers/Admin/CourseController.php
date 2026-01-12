<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        return view('admin.courses.index', [
            'courses' => Course::latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'short_description' => 'required|string|max:255',
        'long_description' => 'required|string',

        'who_this_course_is_for' => 'required|array|min:1',
        'curriculum' => 'required|array|min:1',
        'what_you_get' => 'required|array|min:1',
        'why_train_with_us' => 'required|array|min:1',

        'duration_hours' => 'required|integer|min:1',
        'duration_weeks' => 'required|integer|min:1',

        'mode' => 'required|in:live_online,virtual,onsite',
        'schedule' => 'required|string',
        'time' => 'required|string',

        'course_fee' => 'required|numeric|min:0',

        'recording' => 'nullable|boolean',
        'is_featured' => 'nullable|boolean',

        'card_image' => 'required|image|max:2048',
        'hero_image' => 'required|image|max:4096',
    ]);

    // Normalize checkboxes
    $validated['recording'] = $request->boolean('recording');
    $validated['is_featured'] = $request->boolean('is_featured');

    DB::beginTransaction();

    try {
        $validated['card_image'] = $request
            ->file('card_image')
            ->store('courses/cards', 'public');

        $validated['hero_image'] = $request
            ->file('hero_image')
            ->store('courses/heroes', 'public');

        Course::create($validated);

        DB::commit();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Course creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return back()
            ->withInput()
            ->with('error', 'Failed to create course. Please try again.');
    }
}

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $course->update($this->validatedData($request));

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return back()->with('success', 'Course deleted');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'long_description' => 'required|string',

            'who_this_course_is_for' => 'required|array',
            'curriculum' => 'required|array',
            'what_you_get' => 'required|array',
            'why_train_with_us' => 'required|array',

            'duration_hours' => 'required|integer',
            'duration_weeks' => 'required|integer',

            'mode' => 'required|in:live_online,virtual,onsite',

            'schedule' => 'required|string',
            'time' => 'required|string',

            'recording' => 'boolean',
            'is_featured' => 'boolean',

            'course_fee' => 'required|numeric',

            'card_image' => 'required|string',
            'hero_image' => 'required|string',
        ]);
    }
}

