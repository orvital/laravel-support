<?php

namespace Orvital\Support;

use Illuminate\Support\ServiceProvider;
use Orvital\Support\Console\Commands\RouteShowCommand;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public function register(): void
    {
    }

    /**
     * Boot services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'support');

        if ($this->app->runningInConsole()) {
            $this->commands([
                RouteShowCommand::class,
            ]);
        }
    }
}
