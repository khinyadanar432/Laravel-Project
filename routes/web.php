<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\ClubController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


// ========== REDIRECT HOME TO DASHBOARD ==========
Route::get('/', function () {
    // Use Auth facade with check() method
    if (Auth::check()) {
        return redirect()->route('student.dashboard');
    }
    
    // If not logged in, show login page
    return redirect()->route('login');
});

// Simple authentication routes
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Registration routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout route (must be outside guest middleware)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Student routes (protected - requires authentication)
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

     // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
    
    // Clubs - with proper route naming
    Route::prefix('clubs')->name('clubs.')->group(function () {
        // Browse all clubs
        Route::get('/', [ClubController::class, 'index'])->name('index');
        
        // View individual club
        Route::get('/{slug}', [ClubController::class, 'show'])->name('show');
        
        // Join/leave clubs
        Route::post('/{slug}/join', [ClubController::class, 'join'])->name('join');
        Route::post('/{slug}/leave', [ClubController::class, 'leave'])->name('leave');
        Route::delete('/{slug}/cancel-request', [ClubController::class, 'cancelRequest'])->name('cancelRequest');
        
        // My clubs page - FIXED ROUTE
        Route::get('/my/list', [ClubController::class, 'myClubs'])->name('myClubs');
        
    });
});

// Redirect home route
Route::get('/home', function () {
    if (Auth::check()) {
        return redirect()->route('student.dashboard');
    }
    return redirect()->route('login');
})->name('home.redirect');