<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    // Model policies
    protected $policies = [
    ];

    // Boot auth services
    public function boot(): void
    {
        $this->registerPolicies();
    }
} 