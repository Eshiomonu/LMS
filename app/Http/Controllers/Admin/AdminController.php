<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    /**
     * Display the admin dashboard with analytics.
     */
    public function dashboard()
    {
        // User Statistics
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalInstructors = User::where('role', 'instructor')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $activeUsers = User::where('is_active', true)->count();
        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Course Statistics
        $totalCourses = Course::count();
        $publishedCourses = Course::where('is_published', true)->count();
        $draftCourses = Course::where('is_published', false)->count();
        $newCoursesThisMonth = Course::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Category Statistics
        $totalCategories = Category::count();
        $activeCategories = Category::where('is_active', true)->count();

        // Lesson Statistics
        $totalLessons = Lesson::count();
        $publishedLessons = Lesson::where('is_published', true)->count();

        // Enrollment Statistics
        $totalEnrollments = Enrollment::count();
        $activeEnrollments = Enrollment::where('status', 'active')->count();
        $completedEnrollments = Enrollment::where('status', 'completed')->count();
        $newEnrollmentsThisMonth = Enrollment::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Financial Statistics
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $revenueThisMonth = Payment::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
        $revenueLastMonth = Payment::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalPayments = Payment::where('status', 'completed')->count();

        // Approval/Review Statistics
        $pendingCourseApprovals = Course::where('status', 'pending')->count();
        $pendingWithdrawals = 0; // Implement if you have withdrawal system

        // Recent Activities
        $recentUsers = User::latest()->take(5)->get();
        $recentCourses = Course::with('instructor')->latest()->take(5)->get();
        $recentEnrollments = Enrollment::with(['user', 'course'])->latest()->take(5)->get();
        $recentPayments = Payment::with('user')->where('status', 'completed')->latest()->take(5)->get();

        // Popular Courses
        $popularCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        // Top Instructors
        $topInstructors = User::where('role', 'instructor')
            ->withCount('createdCourses')
            ->orderBy('created_courses_count', 'desc')
            ->take(5)
            ->get();

        // Monthly Revenue Chart Data (last 12 months)
        $monthlyRevenue = Payment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Monthly Enrollments Chart Data (last 12 months)
        $monthlyEnrollments = Enrollment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calculate growth percentages
        $userGrowth = $this->calculateGrowth(
            User::whereMonth('created_at', Carbon::now()->month)->count(),
            User::whereMonth('created_at', Carbon::now()->subMonth()->month)->count()
        );

        $enrollmentGrowth = $this->calculateGrowth(
            $newEnrollmentsThisMonth,
            Enrollment::whereMonth('created_at', Carbon::now()->subMonth()->month)->count()
        );

        $revenueGrowth = $this->calculateGrowth($revenueThisMonth, $revenueLastMonth);

        $courseGrowth = $this->calculateGrowth(
            $newCoursesThisMonth,
            Course::whereMonth('created_at', Carbon::now()->subMonth()->month)->count()
        );

        return view('admin.dashboard', compact(
            // User Stats
            'totalUsers',
            'totalStudents',
            'totalInstructors',
            'totalAdmins',
            'activeUsers',
            'newUsersThisMonth',
            
            // Course Stats
            'totalCourses',
            'publishedCourses',
            'draftCourses',
            'newCoursesThisMonth',
            
            // Category & Lesson Stats
            'totalCategories',
            'activeCategories',
            'totalLessons',
            'publishedLessons',
            
            // Enrollment Stats
            'totalEnrollments',
            'activeEnrollments',
            'completedEnrollments',
            'newEnrollmentsThisMonth',
            
            // Financial Stats
            'totalRevenue',
            'revenueThisMonth',
            'revenueLastMonth',
            'pendingPayments',
            'totalPayments',
            
            // Approvals
            'pendingCourseApprovals',
            'pendingWithdrawals',
            
            // Recent Activities
            'recentUsers',
            'recentCourses',
            'recentEnrollments',
            'recentPayments',
            
            // Popular & Top
            'popularCourses',
            'topInstructors',
            
            // Chart Data
            'monthlyRevenue',
            'monthlyEnrollments',
            
            // Growth Percentages
            'userGrowth',
            'enrollmentGrowth',
            'revenueGrowth',
            'courseGrowth'
        ));
    }

    /**
     * Calculate growth percentage between two values.
     */
    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 2);
    }

    /**
     * Display admin profile.
     */
    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'required_with:password',
            'password' => 'nullable|confirmed|min:8',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Verify current password if changing password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect.');
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        unset($validated['current_password']);
        $user->update($validated);

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully.');
    }
}
