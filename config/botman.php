<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Conversation Cache Time
    |--------------------------------------------------------------------------
    |
    | BotMan caches each started conversation. This value defines the
    | number of minutes that a conversation will remain stored in
    | the cache.
    |
    */
    'conversation_cache_time' => 40,

    /*
    |--------------------------------------------------------------------------
    | User Cache Time
    |--------------------------------------------------------------------------
    |
    | BotMan caches user information of the incoming messages.
    | This value defines the number of minutes that this
    | data will remain stored in the cache.
    |
    */
    'user_cache_time' => 30,

    /*
    |--------------------------------------------------------------------------
    | Cache Prefix
    |--------------------------------------------------------------------------
    |
    | BotMan caches all conversation and user information. Here you may define
    | a prefix for your cache keys.
    |
    */

    'cache_prefix' => 'botman',

    /*
    |--------------------------------------------------------------------------
    | Database
    |--------------------------------------------------------------------------
    |
    | Database driver configuration for the storage driver.
    |
    */

    'database' => config('database.default'),

    'drivers' => [
        'telegram' => [
            'token' => 'YOUR_TELEGRAM_BOT_TOKEN',
        ],

        // Add more driver configurations for other platforms if needed
    ],

    /*
    |--------------------------------------------------------------------------
    | Additional BotMan Studio Configuration
    |--------------------------------------------------------------------------
    |
    | BotMan Studio will try to use the `config('botman.studio')` configuration
    | file. However, you may programmatically configure your studio service
    | provider class here.
    |
    */

    'studio' => [
        'provider' => \BotMan\Studio\Providers\StudioServiceProvider::class,
        'middleware' => [
            // Define additional middleware for the BotMan Studio if needed
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Conversation Middleware
    |--------------------------------------------------------------------------
    |
    | Define a middleware (or an array of middleware) to run before each
    | incoming message. You may use this to customize your bot's workflow.
    |
    */

    'middleware' => [],

    /*
    |--------------------------------------------------------------------------
    | cURL Options
    |--------------------------------------------------------------------------
    |
    | BotMan will use this array to prepare every cURL request.
    | The same option can be set per driver in the relative
    | driver configuration file. It uses the
    | curl_setopt_array() function.
    |
    */
    'curl_options' => [],

];
