@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('header-title', 'Dashboard Overview')

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 1.5rem;
    }
    
    .growth-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    .table-recent {
        font-size: 0.9rem;
    }
    
    .metric-value {
        font-size: 2rem;
        font-weight: 700;
    }
</style>
@endpush

@section('content')

<!-- Quick Stats Cards -->
<div class="row g-3 mb-4">
    <!-- Total Users -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 text-uppercase small fw-semibold">Total Users</p>
                        <h2 class="metric-value mb-0">{{ number_format($totalUsers) }}</h2>
                        @if($userGrowth != 0)
                            <span class="growth-badge badge {{ $userGrowth > 0 ? 'bg-success' : 'bg-danger' }} mt-2">
                                <i class="bi bi-{{ $userGrowth > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                {{ abs($userGrowth) }}% from last month
                            </span>
                        @endif
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bi bi-person-check me-1"></i>{{ number_format($activeUsers) }} Active
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Courses -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 text-uppercase small fw-semibold">Total Courses</p>
                        <h2 class="metric-value mb-0">{{ number_format($totalCourses) }}</h2>
                        @if($courseGrowth != 0)
                            <span class="growth-badge badge {{ $courseGrowth > 0 ? 'bg-success' : 'bg-danger' }} mt-2">
                                <i class="bi bi-{{ $courseGrowth > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                {{ abs($courseGrowth) }}% from last month
                            </span>
                        @endif
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-book-fill"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bi bi-eye me-1"></i>{{ number_format($publishedCourses) }} Published
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Enrollments -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 text-uppercase small fw-semibold">Total Enrollments</p>
                        <h2 class="metric-value mb-0">{{ number_format($totalEnrollments) }}</h2>
                        @if($enrollmentGrowth != 0)
                            <span class="growth-badge badge {{ $enrollmentGrowth > 0 ? 'bg-success' : 'bg-danger' }} mt-2">
                                <i class="bi bi-{{ $enrollmentGrowth > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                {{ abs($enrollmentGrowth) }}% from last month
                            </span>
                        @endif
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bi bi-check-circle me-1"></i>{{ number_format($completedEnrollments) }} Completed
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 text-uppercase small fw-semibold">Total Revenue</p>
                        <h2 class="metric-value mb-0">${{ number_format($totalRevenue, 2) }}</h2>
                        @if($revenueGrowth != 0)
                            <span class="growth-badge badge {{ $revenueGrowth > 0 ? 'bg-success' : 'bg-danger' }} mt-2">
                                <i class="bi bi-{{ $revenueGrowth > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                {{ abs($revenueGrowth) }}% from last month
                            </span>
                        @endif
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bi bi-calendar-month me-1"></i>${{ number_format($revenueThisMonth, 2) }} This Month
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-person-badge text-primary" style="font-size: 2rem;"></i>
                <h4 class="mt-2 mb-0">{{ number_format($totalInstructors) }}</h4>
                <small class="text-muted">Instructors</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-grid text-success" style="font-size: 2rem;"></i>
                <h4 class="mt-2 mb-0">{{ number_format($totalCategories) }}</h4>
                <small class="text-muted">Categories</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-journal-text text-info" style="font-size: 2rem;"></i>
                <h4 class="mt-2 mb-0">{{ number_format($totalLessons) }}</h4>
                <small class="text-muted">Lessons</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-hourglass-split text-warning" style="font-size: 2rem;"></i>
                <h4 class="mt-2 mb-0">{{ number_format($pendingCourseApprovals) }}</h4>
                <small class="text-muted">Pending Approvals</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <!-- Revenue Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-graph-up text-primary me-2"></i>Revenue Overview (Last 12 Months)
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollment Chart -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pie-chart text-success me-2"></i>User Distribution
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="userDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities and Popular Content -->
<div class="row g-3 mb-4">
    <!-- Recent Enrollments -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-clock-history text-info me-2"></i>Recent Enrollments
                </h5>
                <a href="{{ route('admin.enrollments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-recent mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEnrollments as $enrollment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    {{ strtoupper(substr($enrollment->user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <span>{{ $enrollment->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($enrollment->course->title, 30) }}</td>
                                    <td>
                                        <small class="text-muted">{{ $enrollment->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No recent enrollments</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Courses -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-star text-warning me-2"></i>Popular Courses
                </h5>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-recent mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Course</th>
                                <th>Enrollments</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($popularCourses as $course)
                                <tr>
                                    <td>{{ Str::limit($course->title, 35) }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $course->enrollments_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $course->is_published ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $course->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No courses available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users and Top Instructors -->
<div class="row g-3">
    <!-- Recent Users -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-person-plus text-success me-2"></i>Recent Users
                </h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-recent mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'instructor' ? 'warning' : 'info') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent users</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Instructors -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-trophy text-warning me-2"></i>Top Instructors
                </h5>
                <a href="{{ route('admin.instructors.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-recent mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Instructor</th>
                                <th>Courses</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topInstructors as $instructor)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    {{ strtoupper(substr($instructor->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <span>{{ $instructor->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $instructor->created_courses_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $instructor->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $instructor->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No instructors found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
