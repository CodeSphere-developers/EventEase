<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// --- Authentication Routes ---

// Guest-only routes (login/register) - redirect to dashboard if already authenticated
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Protected Dashboard Routes ---
Route::middleware('auth')->group(function () {
    // Student: Delete own feedback
    Route::delete('/feedback/self/{id}', [\App\Http\Controllers\FeedbackController::class, 'destroySelf'])->name('feedback.destroySelf');
    // Admin: Manage Feedback Page
    Route::get('/feedback/manage', [\App\Http\Controllers\FeedbackController::class, 'manage'])->name('feedback.manage');
    // Admin: Delete feedback
    Route::delete('/feedback/{id}', [\App\Http\Controllers\FeedbackController::class, 'destroy'])->name('feedback.destroy');
    // Admin: Event Registration (Publish Event) Page
    Route::get('/events/create', function() {
        $venues = \App\Models\Venue::all();
        $categories = \App\Models\Category::all();
        return view('admin_event_create', compact('venues', 'categories'));
    })->name('events.create')->middleware('auth');

    // Admin: Manage Events Page
    Route::get('/events/manage', function() {
        $events = \App\Models\Event::with('venue', 'category')->withCount('registrations')->orderBy('event_date', 'asc')->get();
        return view('admin_event_manage', compact('events'));
    })->name('events.manage')->middleware('auth');
    // Admin Edit/Update Event
    Route::get('/events/{id}/edit', [DashboardController::class, 'editEvent'])->name('events.edit');
    Route::put('/events/{id}/update', [DashboardController::class, 'updateEvent'])->name('events.update');
    
    // Main Dashboard (public for all logged-in users)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Student Profile: View registered events
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    // Student Actions (Register Only, No Payment)
    Route::post('/event/{id}/register', [DashboardController::class, 'registerForEvent'])->name('event.register');
    // Feedback Submission
    Route::post('/event/{id}/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('event.feedback');
    // Unregister from Event
    Route::post('/event/{id}/unregister', [DashboardController::class, 'unregisterForEvent'])->name('event.unregister');
    
    // Admin Actions
    Route::post('/events', [DashboardController::class, 'storeEvent'])->name('events.store');
    Route::delete('/events/{id}', [DashboardController::class, 'destroyEvent'])->name('events.destroy');
    Route::post('/event/{id}/toggle', [DashboardController::class, 'toggleStatus'])->name('event.toggle');
});