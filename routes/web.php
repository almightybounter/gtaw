<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

// Test MySQL database connection
Route::get('/test-db', function () {
    try {
        $connection = DB::connection();
        $pdo = $connection->getPdo();
        
        $output = '<h1>MySQL Database Connection Test</h1>';
        $output .= '<p><strong>✅ Connection successful!</strong></p>';
        $output .= '<p><strong>Database Type:</strong> ' . $connection->getDriverName() . '</p>';
        $output .= '<p><strong>Database Name:</strong> ' . $connection->getDatabaseName() . '</p>';
        $output .= '<p><strong>Host:</strong> ' . config('database.connections.mysql.host') . '</p>';
        $output .= '<p><strong>Port:</strong> ' . config('database.connections.mysql.port') . '</p>';
        
        // Test a simple query
        $result = DB::select('SELECT VERSION() as version');
        $output .= '<p><strong>MySQL Version:</strong> ' . $result[0]->version . '</p>';
        
        // Check if our tables exist
        $tables = DB::select('SHOW TABLES');
        $output .= '<p><strong>Tables found:</strong> ' . count($tables) . '</p>';
        
        if (count($tables) > 0) {
            $output .= '<ul>';
            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                $output .= '<li>' . $tableName . '</li>';
            }
            $output .= '</ul>';
        } else {
            $output .= '<p><em>No tables found. You may need to run migrations.</em></p>';
        }
        
        return $output;
        
    } catch (Exception $e) {
        return '<h1>❌ Database Connection Failed</h1><p><strong>Error:</strong> ' . $e->getMessage() . '</p><p><strong>File:</strong> ' . $e->getFile() . '</p><p><strong>Line:</strong> ' . $e->getLine() . '</p>';
    }
})->name('test-db');

// Database connection info for debugging deployment
Route::get('/db-debug', function () {
    try {
        $output = '<h1>Database Configuration Debug</h1>';
        $output .= '<p><strong>DB_CONNECTION:</strong> ' . config('database.default') . '</p>';
        $output .= '<p><strong>DB_HOST:</strong> ' . config('database.connections.mysql.host') . '</p>';
        $output .= '<p><strong>DB_PORT:</strong> ' . config('database.connections.mysql.port') . '</p>';
        $output .= '<p><strong>DB_DATABASE:</strong> ' . config('database.connections.mysql.database') . '</p>';
        $output .= '<p><strong>DB_USERNAME:</strong> ' . config('database.connections.mysql.username') . '</p>';
        $output .= '<p><strong>Environment:</strong> ' . app()->environment() . '</p>';
        
        // Test if we can even create a connection
        try {
            $connection = DB::connection();
            $pdo = $connection->getPdo();
            $output .= '<p><strong>✅ Connection object created successfully</strong></p>';
        } catch (Exception $e) {
            $output .= '<p><strong>❌ Connection failed:</strong> ' . $e->getMessage() . '</p>';
        }
        
        return $output;
        
    } catch (Exception $e) {
        return '<h1>❌ Debug Error</h1><p><strong>Error:</strong> ' . $e->getMessage() . '</p>';
    }
})->name('db-debug');

// Database inspection routes
Route::get('/db-info', function () {
    try {
        $connection = DB::connection();
        $pdo = $connection->getPdo();
        
        $output = '<h1>Database Information</h1>';
        $output .= '<p><strong>Database Type:</strong> ' . $connection->getDriverName() . '</p>';
        $output .= '<p><strong>Database Name:</strong> ' . $connection->getDatabaseName() . '</p>';
        
        // Get all tables
        if ($connection->getDriverName() === 'pgsql') {
            $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        } else {
            $tables = DB::select('SHOW TABLES');
        }
        
        $output .= '<h2>Tables (' . count($tables) . ')</h2><ul>';
        foreach ($tables as $table) {
            $tableName = $connection->getDriverName() === 'pgsql' ? $table->table_name : array_values((array)$table)[0];
            $output .= '<li><a href="/db-table/' . $tableName . '">' . $tableName . '</a></li>';
        }
        $output .= '</ul>';
        
        return $output;
        
    } catch (Exception $e) {
        return '<h1>Database Error</h1><p>Error: ' . $e->getMessage() . '</p>';
    }
})->name('db-info');

Route::get('/db-table/{table}', function ($table) {
    try {
        $connection = DB::connection();
        
        $output = '<h1>Table: ' . $table . '</h1>';
        $output .= '<p><a href="/db-info">← Back to all tables</a></p>';
        
        // Get column information
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
        
        // Get record count
        $count = DB::table($table)->count();
        $output .= '<h2>Data (' . $count . ' records)</h2>';
        
        if ($count > 0 && $count <= 20) {
            // Show data if not too many records
            $records = DB::table($table)->get();
            
            $output .= '<table border="1" style="border-collapse: collapse; width: 100%; font-size: 12px;">';
            
            // Header
            $firstRecord = $records->first();
            if ($firstRecord) {
                $output .= '<tr>';
                foreach ($firstRecord as $key => $value) {
                    $output .= '<th>' . $key . '</th>';
                }
                $output .= '</tr>';
                
                // Data rows
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