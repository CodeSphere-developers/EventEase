<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // We will create this next

// 1. Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login'); // Home is login
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Dashboard Route (Protected: You must be logged in)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Actions
    Route::post('/event/{id}/register', [DashboardController::class, 'registerForEvent'])->name('event.register');
    Route::post('/event/{id}/toggle', [DashboardController::class, 'toggleStatus'])->name('event.toggle');
});