<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('category')->withCount('enrollments')->withTrashed();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $courses    = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'total'     => Course::withTrashed()->count(),
            'published' => Course::where('status', 'published')->count(),
            'draft'     => Course::where('status', 'draft')->count(),
            'archived'  => Course::where('status', 'archived')->count(),
        ];

        return view('admin.courses.index', compact('courses', 'categories', 'stats'));
    }

    public function create()
    {
        $categories  = Category::where('is_active', true)->orderBy('name')->get();
        $instructors = User::where('role', 'student')->orWhere('role', 'admin')->get();
        return view('admin.courses.create', compact('categories', 'instructors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'               => ['required', 'string', 'max:255'],
            'subtitle'            => ['nullable', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'category_id'         => ['nullable', 'exists:categories,id'],
            'level'               => ['required', 'in:beginner,intermediate,advanced'],
            'price'               => ['required', 'numeric', 'min:0'],
            'discount_price'      => ['nullable', 'numeric', 'min:0'],
            'currency'            => ['required', 'string', 'max:3'],
            'duration_hours'      => ['nullable', 'integer', 'min:0'],
            'duration_weeks'      => ['nullable', 'integer', 'min:0'],
            'schedule'            => ['nullable', 'string', 'max:255'],
            'mode'                => ['nullable', 'string', 'max:255'],
            'language'            => ['required', 'string', 'max:50'],
            'status'              => ['required', 'in:draft,pending,published,archived'],
            'is_featured'         => ['boolean'],
            'is_published'        => ['boolean'],
            'thumbnail'           => ['nullable', 'image', 'max:2048'],
            'what_you_will_learn' => ['nullable', 'string'],
            'who_course_is_for'   => ['nullable', 'string'],
            'course_curriculum'   => ['nullable', 'string'],
            'what_you_get'        => ['nullable', 'string'],
            'why_train_with_us'   => ['nullable', 'string'],
            'requirements'        => ['nullable', 'string'],
            'tags'                => ['nullable', 'string'],
            'meta_title'          => ['nullable', 'string', 'max:255'],
            'meta_description'    => ['nullable', 'string'],
        ]);

        // Handle JSON textarea fields (newline-separated → array)
        foreach (['what_you_will_learn', 'who_course_is_for', 'course_curriculum', 'what_you_get', 'requirements'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = array_filter(array_map('trim', explode("\n", $data[$field])));
            }
        }
        if (isset($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        // Thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $data['slug']          = Str::slug($data['title']);
        $data['instructor_id'] = auth('admin')->id() ?? 1; // fallback; replace with real logic
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
            $data['is_published'] = true;
        }

        Course::create($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['category', 'enrollments.user']);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories  = Category::where('is_active', true)->orderBy('name')->get();
        $instructors = User::where('role', 'student')->orWhere('role', 'admin')->get();
        return view('admin.courses.edit', compact('course', 'categories', 'instructors'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'               => ['required', 'string', 'max:255'],
            'subtitle'            => ['nullable', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'category_id'         => ['nullable', 'exists:categories,id'],
            'level'               => ['required', 'in:beginner,intermediate,advanced'],
            'price'               => ['required', 'numeric', 'min:0'],
            'discount_price'      => ['nullable', 'numeric', 'min:0'],
            'currency'            => ['required', 'string', 'max:3'],
            'duration_hours'      => ['nullable', 'integer', 'min:0'],
            'duration_weeks'      => ['nullable', 'integer', 'min:0'],
            'schedule'            => ['nullable', 'string', 'max:255'],
            'mode'                => ['nullable', 'string', 'max:255'],
            'language'            => ['required', 'string', 'max:50'],
            'status'              => ['required', 'in:draft,pending,published,archived'],
            'is_featured'         => ['boolean'],
            'thumbnail'           => ['nullable', 'image', 'max:2048'],
            'what_you_will_learn' => ['nullable', 'string'],
            'who_course_is_for'   => ['nullable', 'string'],
            'course_curriculum'   => ['nullable', 'string'],
            'what_you_get'        => ['nullable', 'string'],
            'why_train_with_us'   => ['nullable', 'string'],
            'requirements'        => ['nullable', 'string'],
            'tags'                => ['nullable', 'string'],
            'meta_title'          => ['nullable', 'string', 'max:255'],
            'meta_description'    => ['nullable', 'string'],
        ]);

        foreach (['what_you_will_learn', 'who_course_is_for', 'course_curriculum', 'what_you_get', 'requirements'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = array_filter(array_map('trim', explode("\n", $data[$field])));
            }
        }
        if (isset($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) Storage::disk('public')->delete($course->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        if ($data['status'] === 'published' && !$course->published_at) {
            $data['published_at'] = now();
            $data['is_published'] = true;
        }

        $course->update($data);

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete(); // soft delete
        return redirect()->route('admin.courses.index')
            ->with('success', 'Course moved to trash.');
    }

    public function publish(Course $course)
    {
        $course->update(['status' => 'published', 'is_published' => true, 'published_at' => now()]);
        return back()->with('success', '"' . $course->title . '" is now published.');
    }

    public function unpublish(Course $course)
    {
        $course->update(['status' => 'draft', 'is_published' => false]);
        return back()->with('success', '"' . $course->title . '" moved to draft.');
    }

    public function feature(Course $course)
    {
        $course->update(['is_featured' => !$course->is_featured]);
        $label = $course->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', '"' . $course->title . '" is now ' . $label . '.');
    }

    public function restore($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->restore();
        return back()->with('success', 'Course restored.');
    }

    public function forceDelete($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        if ($course->thumbnail) Storage::disk('public')->delete($course->thumbnail);
        $course->forceDelete();
        return redirect()->route('admin.courses.index')->with('success', 'Course permanently deleted.');
    }
}