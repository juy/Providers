<?php

namespace Juy\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the application services
     *
     * @return void
     */
    public function register()
    {
        // Default package configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/providers.php', 'providers'
        );

        // If providers config not null
        if ($this->app['config']->get('providers') !== null)
        {
            // Register App and Vendor providers
            $this->registerServices(array_merge(
                $this->app['config']->get('providers.providers.app'),
                $this->app['config']->get('providers.providers.vendor')
            ));

            // Register App and Vendor aliases
            $this->registerAliases(array_merge(
                $this->app['config']->get('providers.aliases.app'),
                $this->app['config']->get('providers.aliases.vendor')
            ));

            // Local
            if ($this->app['config']->get('app.env') === 'local')
            {
                // Register Local providers
                $this->registerServices($this->app['config']->get('providers.providers.local'));

                // Register Local aliases
                $this->registerAliases($this->app['config']->get('providers.aliases.local'));
            }
        }
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the config file
        $this->publishConfig();
    }

    /**
     * Publish the config file.
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/providers.php' => config_path('providers.php')
        ], 'config');
    }

    /**
     * Register providers.
     *
     * @param array $providers
     * @return void
     */
    private function registerServices(array $providers)
    {
        foreach ($providers as $provider)
        {
            $this->app->register($provider);
        }
    }

    /**
     * Register Aliases.
     *
     * @param array $aliases
     * @return void
     */
    private function registerAliases(array $aliases)
    {
        $aliasLoader = AliasLoader::getInstance();

        foreach ($aliases as $alias => $facade)
        {
            $aliasLoader->alias($alias, $facade);
        }
    }
}
