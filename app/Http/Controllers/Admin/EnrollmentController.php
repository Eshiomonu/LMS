<?php
// ── SAVE AS: app/Http/Controllers/Admin/EnrollmentController.php ──

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'course'])->latest();

        if ($request->filled('status'))  $query->where('status', $request->status);
        if ($request->filled('payment')) $query->where('payment_status', $request->payment);
        if ($request->filled('course'))  $query->where('course_id', $request->course);
        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%'));
        }

        $enrollments = $query->paginate(20)->withQueryString();
        $courses     = Course::where('is_published', true)->orderBy('title')->get();

        $stats = [
            'total'     => Enrollment::count(),
            'pending'   => Enrollment::where('status', 'pending')->count(),
            'approved'  => Enrollment::where('status', 'approved')->count(),
            'rejected'  => Enrollment::where('status', 'rejected')->count(),
            'completed' => Enrollment::where('status', 'completed')->count(),
        ];

        return view('admin.enrollments.index', compact('enrollments', 'courses', 'stats'));
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['user', 'course.category']);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function approve(Request $request, Enrollment $enrollment)
    {
        $enrollment->update([
            'status'      => 'approved',
            'approved_at' => now(),
            'approved_by' => auth('admin')->id(),
            'admin_notes' => $request->admin_notes,
        ]);
        return back()->with('success', 'Enrollment approved for ' . $enrollment->user->name . '.');
    }

    public function reject(Request $request, Enrollment $enrollment)
    {
        $request->validate(['rejection_reason' => ['required', 'string', 'max:500']]);
        $enrollment->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'admin_notes'      => $request->admin_notes,
        ]);
        return back()->with('success', 'Enrollment rejected.');
    }

    public function complete(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'completed']);
        return back()->with('success', 'Enrollment marked as completed.');
    }

    public function notes(Request $request, Enrollment $enrollment)
    {
        $request->validate(['admin_notes' => ['nullable', 'string', 'max:1000']]);
        $enrollment->update(['admin_notes' => $request->admin_notes]);
        return back()->with('success', 'Notes saved.');
    }
}