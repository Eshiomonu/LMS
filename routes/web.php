<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminAuthController;

// Route::get('/', function () {
//     return view('pages.home');
// })->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Auth Routes (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')
    ->middleware('auth:admin')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });



require __DIR__.'/auth.php';



// Home Page
Route::get('/', [CourseController::class, 'home'])->name('home');

// Courses Listing
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

// Single Course Page
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

// Enrollment (requires login)
Route::middleware('auth')->get('/courses/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

