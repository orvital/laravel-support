<?php

namespace Orvital\Support\Extensions\Session;

use Illuminate\Support\ServiceProvider;
use Orvital\Support\Extensions\Session\SessionManager;

/**
 * @property-read \Illuminate\Foundation\Application $app
 */
class SessionProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public function register(): void
    {
        // Singleton / Not Deferred
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
