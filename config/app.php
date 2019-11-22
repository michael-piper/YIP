<?php

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

    'name' => env('APP_NAME', 'Laravel'),

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
    'avatar'=>'data:image/jpeg;base64,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',

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

    'debug' => env('APP_DEBUG', false),

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

    'timezone' => 'UTC',

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
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

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

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

    ],

];
