<?php

namespace Orvital\Support;

use Carbon\CarbonImmutable;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Support\Facades\Date;
use Orvital\Support\Console\Commands\RouteShowCommand;
use Orvital\Support\Extensions\Migration\MigrationProvider;
use Orvital\Support\Extensions\Session\SessionProvider;

class SupportServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        SessionProvider::class,
        MigrationProvider::class,
    ];

    /**
     * Boot services.
     */
    public function boot(): void
    {
        Builder::defaultStringLength(192);

        // Use CarbonImmutable by default
        Date::use(CarbonImmutable::class);

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'support');

        if ($this->app->runningInConsole()) {
            $this->commands([
                RouteShowCommand::class,
            ]);
        }
    }
}
