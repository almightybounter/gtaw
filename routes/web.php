<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Simple test route to verify Laravel is working
Route::get('/test', function () {
    return '<h1>Laravel is working!</h1><p>If you see this, the problem is likely with the welcome view or assets.</p>';
})->name('test');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Notes resource routes - RESTful
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('notes', NoteController::class);
    
    // Profile routes for user management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; 