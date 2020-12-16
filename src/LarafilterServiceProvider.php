<?php

namespace Mjedari\Larafilter;

use Illuminate\Support\ServiceProvider;

class LarafilterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->registerConfigPublishing();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'larafilter');

        $this->registerFacades();

        $this->commands([
            Console\MakeFilterCommand::class,
        ]);
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerConfigPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('larafilter.php'),
        ], 'larafilter');
    }

    protected function registerFacades()
    {
        // Register the main class to use with the facade
        $this->app->singleton('LaraFilter', function () {
            return new Larafilter;
        });
    }
}
