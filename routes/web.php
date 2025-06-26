<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Dev: Database table inspector
Route::get('/db-table/{table}', function ($table) {
    try {
        $connection = DB::connection();
        
        $output = '<h1>Table: ' . $table . '</h1>';
        $output .= '<p><a href="/db-info">← Back to all tables</a></p>';
        
        // Get column info (PostgreSQL vs MySQL)
        if ($connection->getDriverName() === 'pgsql') {
            $columns = DB::select("SELECT column_name, data_type, is_nullable, column_default 
                                  FROM information_schema.columns 
                                  WHERE table_name = ? AND table_schema = 'public'", [$table]);
        } else {
            $columns = DB::select('DESCRIBE ' . $table);
        }
        
        $output .= '<h2>Columns</h2><table border="1" style="border-collapse: collapse; width: 100%;">';
        $output .= '<tr><th>Name</th><th>Type</th><th>Nullable</th><th>Default</th></tr>';
        
        foreach ($columns as $column) {
            if ($connection->getDriverName() === 'pgsql') {
                $output .= '<tr>';
                $output .= '<td>' . $column->column_name . '</td>';
                $output .= '<td>' . $column->data_type . '</td>';
                $output .= '<td>' . $column->is_nullable . '</td>';
                $output .= '<td>' . ($column->column_default ?? 'NULL') . '</td>';
                $output .= '</tr>';
            } else {
                $output .= '<tr>';
                $output .= '<td>' . $column->Field . '</td>';
                $output .= '<td>' . $column->Type . '</td>';
                $output .= '<td>' . $column->Null . '</td>';
                $output .= '<td>' . ($column->Default ?? 'NULL') . '</td>';
                $output .= '</tr>';
            }
        }
        $output .= '</table>';
        
        // Show table data
        $count = DB::table($table)->count();
        $output .= '<h2>Data (' . $count . ' records)</h2>';
        
        if ($count > 0 && $count <= 20) {
            $records = DB::table($table)->get();
            
            $output .= '<table border="1" style="border-collapse: collapse; width: 100%; font-size: 12px;">';
            
            $firstRecord = $records->first();
            if ($firstRecord) {
                $output .= '<tr>';
                foreach ($firstRecord as $key => $value) {
                    $output .= '<th>' . $key . '</th>';
                }
                $output .= '</tr>';
                
                foreach ($records as $record) {
                    $output .= '<tr>';
                    foreach ($record as $key => $value) {
                        $displayValue = $value;
                        if (strlen($displayValue) > 50) {
                            $displayValue = substr($displayValue, 0, 50) . '...';
                        }
                        $output .= '<td>' . htmlspecialchars($displayValue) . '</td>';
                    }
                    $output .= '</tr>';
                }
            }
            
            $output .= '</table>';
        } elseif ($count > 20) {
            $output .= '<p>Too many records to display. Showing first 5:</p>';
            $records = DB::table($table)->limit(5)->get();
            
            $output .= '<table border="1" style="border-collapse: collapse; width: 100%; font-size: 12px;">';
            
            $firstRecord = $records->first();
            if ($firstRecord) {
                $output .= '<tr>';
                foreach ($firstRecord as $key => $value) {
                    $output .= '<th>' . $key . '</th>';
                }
                $output .= '</tr>';
                
                foreach ($records as $record) {
                    $output .= '<tr>';
                    foreach ($record as $key => $value) {
                        $displayValue = $value;
                        if (strlen($displayValue) > 50) {
                            $displayValue = substr($displayValue, 0, 50) . '...';
                        }
                        $output .= '<td>' . htmlspecialchars($displayValue) . '</td>';
                    }
                    $output .= '</tr>';
                }
            }
            
            $output .= '</table>';
        } else {
            $output .= '<p>No records found.</p>';
        }
        
        return $output;
        
    } catch (Exception $e) {
        return '<h1>Table Error</h1><p>Error: ' . $e->getMessage() . '</p>';
    }
})->name('db-table');

// Auth required routes
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Protected resource routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('notes', NoteController::class);
    // User profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; 
