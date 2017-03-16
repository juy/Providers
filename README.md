# Providers Laravel Package

[![Latest Version on Packagist][ico-version]][link-packagist] [![Software License][ico-license]](LICENSE.txt)

> Laravel package to load providers and aliases use a config file.

We usually use a providers file for load local providers, package providers, aliases, etc. to try keep clean `config/app.php` file. We have developed this idea and make a package for this.

----------

### Supported Laravel versions

- Laravel **5.1** | **5.2** | **5.3**

### Requirements

- Laravel >= 5.1 : Laravel 5.1 or above.
- PHP >= 5.5.9 : PHP 5.5.9 or above on your machine.

## Installation

### Step:1 Install through composer

#### Install

```
➜ composer require juy/providers:1.*
```

> #### Manual install (alternative)

> Simply add the following to the "require" section of your composer.json file, and run `composer update` command.

> ```json
>"juy/providers": "1.*"
>```

#### Remove

```
➜ composer remove juy/providers
```

### Step 2: Add the service provider

Append this line to your **service providers** array in `config/app.php`.

```php
Juy\Providers\ServiceProvider::class,
```

### 3. Step 3: Publish config

Publish config file.

```
➜ php artisan vendor:publish --provider="Juy\Providers\ServiceProvider" --tag="config"
```

## Usage

You can add providers to `config/providers.php` file.

### A config sample

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
        * Package Service Providers
        */
       'package' => [
            Collective\Html\HtmlServiceProvider::class,
            Juy\CharacterSolver\ServiceProvider::class,
            Juy\ActiveMenu\ServiceProvider::class,
       ],

       /*
        * Development/Local Service Providers
        */
        'local' => [
            Barryvdh\Debugbar\ServiceProvider::class,
            Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
            Clockwork\Support\Laravel\ClockworkServiceProvider::class,
        ],
        
       /*
        * Production Service Providers
        */
        'production' => [
            GrahamCampbell\HTMLMin\HTMLMinServiceProvider::class,
        ]
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
         * Package Aliases
         */
        'package' => [
            'Html' => Collective\Html\HtmlFacade::class
        ],

        /*
         * Development/Local Aliases
         */
        'local' => [
            'Debugbar' => Barryvdh\Debugbar\Facade::class,
        ],
        
       /*
        * Production Aliases
        */
        'production' => [
            'HTMLMin' => GrahamCampbell\HTMLMin\Facades\HTMLMin::class,
        ]
    ]
];

```

----------

### License

This project is open-sourced software licensed under the [MIT License](LICENSE.txt).


[ico-version]: https://img.shields.io/packagist/v/juy/providers.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/juy/providers

[ico-license]: https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square