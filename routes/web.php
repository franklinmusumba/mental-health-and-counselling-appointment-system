<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\BookingController;
use App\Http\Controllers\Student\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated (any role)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Student / Patient routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Patient'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/book',      [BookingController::class, 'index'])->name('book');
        Route::post('/book',     [BookingController::class, 'store'])->name('book.store');
    });

/*
|--------------------------------------------------------------------------
| Counsellor / Therapist routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Therapist'])
    ->prefix('counsellor')
    ->name('counsellor.')
    ->group(function () {
        Route::view('/schedule', 'counsellor.schedule')->name('schedule');
    });

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));