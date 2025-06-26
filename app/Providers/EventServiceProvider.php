<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Failed as LoginFailed;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LoginFailed::class => [
            'App\Listeners\LogFailedLogin',
        ],
    ];

    public function boot(): void
    {
        Event::listen(LoginFailed::class, function (LoginFailed $event) {
            Log::channel('note_actions')->warning('Failed login attempt', [
                'email' => $event->credentials['email'] ?? 'unknown',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'timestamp' => now(),
                'action' => 'failed_login',
            ]);
        });
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
} 