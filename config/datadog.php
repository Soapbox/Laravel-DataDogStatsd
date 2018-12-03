<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DogStatsd Driver
    |--------------------------------------------------------------------------
    |
    | This option defines the DogStatsd type to use. The name specified in this
    | option should match one of the drivers defined in the "drivers"
    | configuration array.
    |
    */

    'driver' => 'batched',

    /*
    |--------------------------------------------------------------------------
    | DogStatsd Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the DogStatsd instance for your application. These
    | configuration values are passed to the DogStatsd instance. You can check
    | out https://github.com/DataDog/php-datadogstatsd to see what the different
    | configuration values do.
    |
    | Available Drivers: "single", "batched"
    |
    */

    'drivers' => [
        'single' => [
            'host' => null,
            'port' => null,
            'socket_path' => null,
            'global_tags' => null,

            'api_key' => null,
            'app_key' => null,
            'curl_ssl_verify_host' => null,
            'curl_ssl_verify_peer' => null,
            'datadog_host' => null,
        ],
        'batched' => [
            'host' => null,
            'port' => null,
            'socket_path' => null,
            'global_tags' => null,

            'api_key' => null,
            'app_key' => null,
            'curl_ssl_verify_host' => null,
            'curl_ssl_verify_peer' => null,
            'datadog_host' => null,
        ],
    ],

];
