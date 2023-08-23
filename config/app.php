<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
     */

    'name' => env('APP_NAME', 'Art Institute of Chicago'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
     */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
     */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | The domains that this website serves
    |--------------------------------------------------------------------------
    |
    | List all the domains that this website servers. Any requests outside of
    | this list will be redirected to www.
    |
    */
    'allowed_domains' => array_map('trim', explode(',', env('ALLOWED_DOMAINS', env('APP_URL', 'www.artic.edu')))),

    /*
    |--------------------------------------------------------------------------
    | Kiosk Domain
    |--------------------------------------------------------------------------
    |
    | The domain used for rending the "Kiosk" kayout of Interactive Features
    |
     */
    'kiosk_domain' => array_map('trim', explode(',', env('KIOSK_DOMAIN', 'kiosk.artic.edu'))),

    /*
    |--------------------------------------------------------------------------
    | Scrub Domain
    |--------------------------------------------------------------------------
    |
    | List all domains that should automatically be scrubbed from content.
    |
     */
    'scrub_domains' => array_map('trim', explode(',', env('SCRUB_DOMAINS', env('APP_URL', 'www.artic.edu')))),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
     */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
     */

    'timezone' => 'America/Chicago',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
     */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
     */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
     */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | IPinfo Access Token
    |--------------------------------------------------------------------------
    |
    | Used for geotargeting lightboxes.
    |
    | https://ipinfo.io/account
    */

    'ipinfo' => env('IPINFO_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */

     'providers' => ServiceProvider::defaultProviders()->merge([
        // Package Service Providers...
        A17\Twill\TwillServiceProvider::class,

        // Application Service Providers...
        App\Providers\VendorServiceProvider::class,
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\InvalidationServiceProvider::class,
        App\Providers\DebugServiceProvider::class,

        Aic\Hub\Foundation\Providers\ResourceServiceProvider::class
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
     */

    'aliases' => Facade::defaultAliases()->merge([
        'DamsImageService' => App\Facades\DamsImageServiceFacade::class,
        'EmbedConverter' => App\Facades\EmbedConverterFacade::class,
        'SmartyPants' => App\Libraries\SmartyPants::class,
        'FrontendHelpers' => App\Helpers\FrontendHelpers::class,
        'BlockHelpers' => App\Helpers\BlockHelpers::class,
        'ColorHelpers' => App\Helpers\ColorHelpers::class,
        'DateHelpers' => App\Helpers\DateHelpers::class,
        'ImageHelpers' => App\Helpers\ImageHelpers::class,
        'NavHelpers' => App\Helpers\NavHelpers::class,
        'UrlHelpers' => App\Helpers\UrlHelpers::class,
        'QueryHelpers' => App\Helpers\QueryHelpers::class,
        'StringHelpers' => App\Helpers\StringHelpers::class,
    ])->toArray(),

    'editor' => env('APP_EDITOR', 'sublime'),
];
