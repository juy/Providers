# Providers laravel package

[![Laravel](https://img.shields.io/badge/Laravel-5.1-orange.svg?style=flat-square)](http://laravel.com) [![Laravel](https://img.shields.io/badge/Laravel-5.2-orange.svg?style=flat-square)](http://laravel.com)

> Laravel package to load providers and aliases use a config file.

We usually use a providers file for load local providers, vendor providers, aliases, etc. to try keep clean `config/app.php` file. We have developed this idea and make a package for this.

----------

## Installation

### Composer package

Add this package to your `composer.json` file and run `composer update` once.

```json
"juy/providers": "1.*",
```

### Service provider

Append this line to your **service providers** array in `config/app.php`.

```php
Juy\Providers\ServiceProvider::class,
```

### Publish config

Publish config file.

```
php artisan vendor:publish --provider="Juy\Providers\ServiceProvider" --tag="config"
```

## Usage

You can add providers to `config/providers.php` file.

### A config sample for  as

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

   'providers' => [
       /*
        * Application Service Providers
        */
       'app' => [
           // ...
       ],

       /*
        * Vendor Service Providers
        */
       'vendor' => [
            Collective\Html\HtmlServiceProvider::class,
            Kris\LaravelFormBuilder\FormBuilderServiceProvider::class,
            Juy\CharacterSolver\ServiceProvider::class,
            Juy\ActiveMenu\ServiceProvider::class,
       ],

       /*
        * Development/Local Service Providers
        */
        'local' => [
            Barryvdh\Debugbar\ServiceProvider::class,
            Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
        ],
   ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    */

    'aliases' => [
        /*
         * Application Aliases
         */
        'app' => [
            // ...
        ],

        /*
         * Vendor Aliases
         */
        'vendor' => [
            'Html' => Collective\Html\HtmlFacade::class,
            'FormBuilder' => Kris\LaravelFormBuilder\Facades\FormBuilder::class,
            'Active' => Juy\ActiveMenu\Facades\Active::class,
        ],

        /*
         * Development/Local Aliases
         */
        'local' => [
            'Debugbar' => Barryvdh\Debugbar\Facade::class,
        ],
    ]
];

```

----------

### License

This project is open-sourced software licensed under the [MIT License](LICENSE.txt).

