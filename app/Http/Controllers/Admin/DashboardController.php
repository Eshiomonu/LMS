<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_courses'        => Course::count(),
            'published_courses'    => Course::where('is_published', true)->count(),
            'draft_courses'        => Course::where('status', 'draft')->count(),
            'total_students'       => User::where('role', 'student')->count(),
            'new_students_week'    => User::where('role', 'student')
                                         ->where('created_at', '>=', now()->subWeek())->count(),
            'total_enrollments'    => Enrollment::count(),
            'pending_enrollments'  => Enrollment::where('status', 'pending')->count(),
            'approved_enrollments' => Enrollment::where('status', 'approved')->count(),
            'total_categories'     => Category::count(),
        ];

        // Recent 10 enrollments with relationships
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->latest()->take(10)->get();

        // Newest 6 students
        $recentStudents = User::where('role', 'student')
            ->latest()->take(6)->get();

        // Top 5 courses by enrollment count
        $topCourses = Course::withCount('enrollments')
            ->where('is_published', true)
            ->orderByDesc('enrollments_count')
            ->take(5)->get();

        // 7-day enrollment trend
        $rawTrend = Enrollment::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()->keyBy('date');

        $trendDays = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trendDays->push([
                'label' => now()->subDays($i)->format('D'),
                'date'  => $date,
                'count' => $rawTrend[$date]->count ?? 0,
            ]);
        }

        return view('admin.dashboard.index', compact(
            'stats',
            'recentEnrollments',
            'recentStudents',
            'topCourses',
            'trendDays'
        ));
    }
}