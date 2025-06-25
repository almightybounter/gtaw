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

// Test config access
Route::get('/test-config', function () {
    try {
        $env = app()->environment();
        return '<h1>Config Test</h1><p>Environment: ' . $env . '</p>';
    } catch (Exception $e) {
        return '<h1>Config Error</h1><p>Error: ' . $e->getMessage() . '</p>';
    }
})->name('test-config');

// Simple diagnostic route without complex config calls
Route::get('/debug-simple', function () {
    try {
        $info = [
            'timestamp' => date('Y-m-d H:i:s'),
            'php_version' => phpversion(),
            'storage_path_exists' => is_dir(storage_path()),
            'storage_writable' => is_writable(storage_path()),
            'base_path' => base_path(),
            'storage_path' => storage_path(),
        ];
        
        $output = '<h1>Simple Debug Info</h1>';
        foreach ($info as $key => $value) {
            $value = is_bool($value) ? ($value ? 'true' : 'false') : $value;
            $output .= '<p><strong>' . $key . ':</strong> ' . htmlspecialchars($value) . '</p>';
        }
        
        return $output;
        
    } catch (Exception $e) {
        return '<h1>Debug Error</h1><p>Error: ' . $e->getMessage() . '</p>';
    }
})->name('debug-simple');

// Test view rendering
Route::get('/test-view', function () {
    try {
        return view('welcome');
    } catch (Exception $e) {
        return '<h1>View Error</h1><p>Error: ' . $e->getMessage() . '</p><p>File: ' . $e->getFile() . '</p><p>Line: ' . $e->getLine() . '</p>';
    }
})->name('test-view');

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