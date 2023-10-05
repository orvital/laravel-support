<?php

namespace Orvital\Support\Extensions\Session;

use Illuminate\Support\ServiceProvider;
use Orvital\Support\Extensions\Session\SessionManager;

class SessionProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public function register(): void
    {
        // Not Deferred Providers
        $this->app->singleton('session', function ($app) {
            return new SessionManager($app);
        });
    }

    /**
     * Boot services.
     */
    public function boot(): void
    {
    }
}
