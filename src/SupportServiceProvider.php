<?php

namespace Orvital\Support;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Support\Facades\Date;
use Orvital\Support\Console\RouteShowCommand;
use Orvital\Support\Extensions\Migration\MigrationProvider;
use Orvital\Support\Extensions\Session\SessionProvider;

/**
 * @property-read \Illuminate\Foundation\Application $app
 */
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
        Model::shouldBeStrict(! $this->app->isProduction());

        Builder::defaultStringLength(192);

        Builder::defaultMorphKeyType('ulid');

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
