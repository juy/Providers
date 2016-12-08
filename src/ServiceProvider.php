<?php
/**
 * This file is part of the <Providers> laravel package.
 *
 * @author Juy Software <package@juysoft.com>
 * @copyright (c) 2016 Juy Software <package@juysoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Juy\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider
 * 
 * @package Juy\Providers
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Package name
     *
     * @var string
     */
    protected $package = 'providers';

    /**
     * Indicates if loading of the provider is deferred
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
        $this->mergeConfig();
        
        // Count the array recursively. Empty config count is 10.
        if (count($this->app['config']->get('providers'), true) !== 10)
        {
            // Register App and Package providers
            $this->registerServices(array_merge(
                $this->app['config']->get('providers.providers.app'),
                $this->app['config']->get('providers.providers.package')
            ));

            // Register App and Package aliases
            $this->registerAliases(array_merge(
                $this->app['config']->get('providers.aliases.app'),
                $this->app['config']->get('providers.aliases.package')
            ));

            // Local
            if ($this->app['config']->get('app.env') === 'local')
            {
                // Register Local providers
                $this->registerServices($this->app['config']->get('providers.providers.local'));

                // Register Local aliases
                $this->registerAliases($this->app['config']->get('providers.aliases.local'));
            }

            // Production
            if ($this->app['config']->get('app.env') === 'production')
            {
                // Register Local providers
                $this->registerServices($this->app['config']->get('providers.providers.production'));

                // Register Local aliases
                $this->registerAliases($this->app['config']->get('providers.aliases.production'));
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
     * Default package configuration
     *
     * @return void
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom(
            $this->packagePath('config/config.php'), $this->package
        );
    }

    /**
     * Publish the config file
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            $this->packagePath('config/config.php') => config_path($this->package . '.php')
        ], 'config');
    }
    
    /**
     * Register providers
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
     * Register Aliases
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
    
    /**
     * Loads a path relative to the package base directory
     *
     * @param string $path
     * @return string
     */
    protected function packagePath($path = '')
    {
        return sprintf('%s/../%s', __DIR__, $path);
    }
}
