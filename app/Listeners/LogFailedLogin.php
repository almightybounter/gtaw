<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogFailedLogin
{
    public function __construct()
    {
        //
    }

    public function handle(Failed $event): void
    {
        Log::warning('Failed login attempt', [
            'email' => $event->credentials['email'] ?? 'unknown',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
            'guard' => $event->guard,
        ]);
    }
}
