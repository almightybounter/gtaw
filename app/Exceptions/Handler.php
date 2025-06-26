<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // Log levels
    protected $levels = [
    ];

    // Don't report these exceptions
    protected $dontReport = [
    ];

    // Don't flash these inputs
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    // Register exception handling
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }
} 