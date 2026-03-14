<?php

use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────────────────────────
//  CONTROLLER IMPORTS
// ─────────────────────────────────────────────────────────────────────────────

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\Admin\Auth\AuthController           as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController           as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController              as AdminCourseController;
use App\Http\Controllers\Admin\CategoryController            as AdminCategoryController;
use App\Http\Controllers\Admin\EnrollmentController          as AdminEnrollmentController;
use App\Http\Controllers\Admin\UserController                as AdminUserController;
use App\Http\Controllers\Admin\TransactionController         as AdminTransactionController;
use App\Http\Controllers\Admin\SettingsController            as AdminSettingsController;
use App\Http\Controllers\Admin\ProfileController             as AdminProfileController;

use App\Http\Controllers\Student\DashboardController         as StudentDashboardController;
use App\Http\Controllers\Student\EnrollmentController        as StudentEnrollmentController;
use App\Http\Controllers\Student\ProfileController           as StudentProfileController;

// ─────────────────────────────────────────────────────────────────────────────
//  PUBLIC ROUTES
// ─────────────────────────────────────────────────────────────────────────────

Route::get('/',                     [HomeController::class,   'index'])->name('home');
Route::get('/about',                fn() => view('pages.about'))->name('about');
Route::get('/contact',              [ContactController::class, 'show'])->name('contact');
Route::post('/contact',             [ContactController::class, 'send'])->name('contact.send');

Route::get('/courses',              [CourseController::class,  'index'])->name('courses.index');
Route::get('/courses/{slug}',       [CourseController::class,  'show'])->name('courses.show');
Route::post('/courses/{slug}/enroll', [CourseController::class, 'enroll'])
    ->middleware('auth')
    ->name('courses.enroll');

// ─────────────────────────────────────────────────────────────────────────────
//  STUDENT AUTH  (web guard)
// ─────────────────────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get( '/login',    [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',    [AuthenticatedSessionController::class, 'store']);
    Route::get( '/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ─────────────────────────────────────────────────────────────────────────────
//  STUDENT DASHBOARD  (auth + active.user middleware)
// ─────────────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'active.user'])
    ->prefix('dashboard')
    ->name('student.')
    ->group(function () {

        Route::get('/',              [StudentDashboardController::class, 'index'])->name('dashboard');

        // Enrollments
        Route::get('/enrollments',              [StudentEnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/enrollments/{enrollment}', [StudentEnrollmentController::class, 'show'])->name('enrollments.show');

        // Profile
        Route::get( '/profile',          [StudentProfileController::class, 'edit'])->name('profile.edit');
        Route::put( '/profile',          [StudentProfileController::class, 'update'])->name('profile.update');
        Route::put( '/profile/password', [StudentProfileController::class, 'password'])->name('profile.password');
    });

// ─────────────────────────────────────────────────────────────────────────────
//  ADMIN  (prefix: /admin  |  guard: admin  |  middleware: auth.admin)
// ─────────────────────────────────────────────────────────────────────────────

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ── Auth (guest-only) ────────────────────────────────────────────────
        Route::middleware('guest:admin')->group(function () {
            Route::get( '/login', [AdminAuthController::class, 'showLogin'])->name('login');
            Route::post('/login', [AdminAuthController::class, 'login']);
        });

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // ── Protected ────────────────────────────────────────────────────────
        Route::middleware('auth.admin')->group(function () {

            // ── Dashboard ────────────────────────────────────────────────────
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // ── Courses ──────────────────────────────────────────────────────
            Route::resource('courses', AdminCourseController::class);
            // Extra course actions
            Route::post('courses/{course}/publish',   [AdminCourseController::class, 'publish'])->name('courses.publish');
            Route::post('courses/{course}/unpublish', [AdminCourseController::class, 'unpublish'])->name('courses.unpublish');
            Route::post('courses/{course}/feature',   [AdminCourseController::class, 'feature'])->name('courses.feature');
            Route::post('courses/{course}/restore',   [AdminCourseController::class, 'restore'])->name('courses.restore');
            Route::delete('courses/{course}/force',   [AdminCourseController::class, 'forceDelete'])->name('courses.force-delete');

            // ── Categories ───────────────────────────────────────────────────
            Route::resource('categories', AdminCategoryController::class);
            Route::post('categories/{category}/toggle', [AdminCategoryController::class, 'toggle'])->name('categories.toggle');

            // ── Enrollments ──────────────────────────────────────────────────
            Route::get( 'enrollments',                     [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
            Route::get( 'enrollments/{enrollment}',        [AdminEnrollmentController::class, 'show'])->name('enrollments.show');
            Route::post('enrollments/{enrollment}/approve',[AdminEnrollmentController::class, 'approve'])->name('enrollments.approve');
            Route::post('enrollments/{enrollment}/reject', [AdminEnrollmentController::class, 'reject'])->name('enrollments.reject');
            Route::post('enrollments/{enrollment}/complete',[AdminEnrollmentController::class, 'complete'])->name('enrollments.complete');
            Route::put( 'enrollments/{enrollment}/notes',  [AdminEnrollmentController::class, 'notes'])->name('enrollments.notes');

            // ── Users / Students ─────────────────────────────────────────────
            Route::resource('users', AdminUserController::class)->except(['create', 'store']);
            Route::post('users/{user}/suspend',  [AdminUserController::class, 'suspend'])->name('users.suspend');
            Route::post('users/{user}/activate', [AdminUserController::class, 'activate'])->name('users.activate');
            Route::post('users/{user}/approve',  [AdminUserController::class, 'approve'])->name('users.approve');
            Route::post('users/{user}/reject',   [AdminUserController::class, 'reject'])->name('users.reject');

            // ── Transactions / Payments ───────────────────────────────────────
            Route::get('transactions',               [AdminTransactionController::class, 'index'])->name('transactions.index');
            Route::get('transactions/{enrollment}',  [AdminTransactionController::class, 'show'])->name('transactions.show');
            Route::post('transactions/{enrollment}/mark-paid',     [AdminTransactionController::class, 'markPaid'])->name('transactions.mark-paid');
            Route::post('transactions/{enrollment}/mark-refunded', [AdminTransactionController::class, 'markRefunded'])->name('transactions.mark-refunded');

            // ── Admin Profile ─────────────────────────────────────────────────
            Route::get( 'profile',          [AdminProfileController::class, 'edit'])->name('profile.edit');
            Route::put( 'profile',          [AdminProfileController::class, 'update'])->name('profile.update');
            Route::put( 'profile/password', [AdminProfileController::class, 'password'])->name('profile.password');

            // ── Settings ─────────────────────────────────────────────────────
            Route::get('settings',           [AdminSettingsController::class, 'index'])->name('settings.index');
            Route::put('settings',           [AdminSettingsController::class, 'update'])->name('settings.update');
            Route::put('settings/mail',      [AdminSettingsController::class, 'updateMail'])->name('settings.mail');
            Route::put('settings/payment',   [AdminSettingsController::class, 'updatePayment'])->name('settings.payment');
            Route::post('settings/logo',     [AdminSettingsController::class, 'uploadLogo'])->name('settings.logo');
        });
    });