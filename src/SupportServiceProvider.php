<?php

namespace Orvital\Support;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Orvital\Support\Console\RouteShowCommand;

/**
 * @property-read \Illuminate\Foundation\Application $app
 */
class SupportServiceProvider extends ServiceProvider
{
    /**
     * Boot services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());

        Relation::requireMorphMap();

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
