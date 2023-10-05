<?php

namespace Orvital\Support\Extensions\Migration;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Orvital\Support\Extensions\Migration\DatabaseMigrationRepository;
use Orvital\Support\Extensions\Migration\MigrationCreator;

class MigrationProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public function register(): void
    {
        // Deferred Providers
        $this->app->extend('migration.repository', function ($repository, $app) {
            return new DatabaseMigrationRepository($app['db'], $app['config']['database.migrations']);
        });

        $this->app->extend('migration.creator', function ($repository, $app) {
            return new MigrationCreator($app['files'], $app->basePath('stubs'));
        });
    }

    /**
     * Boot services.
     */
    public function boot(): void
    {
        // Migrations paths including subdirectories
        $path = $this->app->databasePath('migrations');
        $this->loadMigrationsFrom([$path, ...File::directories($path)]);
    }
}
