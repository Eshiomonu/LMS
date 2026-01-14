<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CourseController;


Route::get('/', function () {return view('pages.home');})->name('home');
Route::get('/about', function () {return view('pages.about');})->name('about');
Route::get('/contact', function () {return view('pages.contact');})->name('contact');
// Route::get('/', function () {return view('pages.home');})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout/{course}', [App\Http\Controllers\CourseController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{course}/process', [App\Http\Controllers\CourseController::class, 'processCheckout'])->name('checkout.process');
});

Route::get('/courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{course}/enroll', [App\Http\Controllers\CourseController::class, 'enroll'])->name('courses.enroll')->middleware('auth'); 



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
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('courses', CourseController::class);
    });




require __DIR__.'/auth.php';
