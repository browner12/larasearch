<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Search Driver
    |--------------------------------------------------------------------------
    |
    | The search API supports a variety of back-ends via a unified API
    | giving you convenient access to each back-end using the same
    | syntax for each one. Here you may set the search driver.
    |
    | Supported: "elasticsearch", "null"
    |
    */

    'driver' => env('SEARCH_DRIVER', 'elasticsearch'),

    /*
    |--------------------------------------------------------------------------
    | Search Index
    |--------------------------------------------------------------------------
    |
    | The name of the index stored in your search provider.
    |
    */

    'index' => env('SEARCH_INDEX', 'my-application'),

    /*
    |--------------------------------------------------------------------------
    | Search Hosts
    |--------------------------------------------------------------------------
    |
    | The hosts the search engine lives on. This is an array of the defined
    | connections.
    |
    */

    'hosts' => env('SEARCH_HOSTS', ['localhost']),

    /*
    |--------------------------------------------------------------------------
    | Search Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    */

    'connections' => [

        'localhost' => [
            'host' => 'localhost',
            'port' => '9200',
        ],

        'custom' => [
            'host'   => 'foo.com',
            'port'   => '9200',
            'scheme' => 'https',
            'user'   => 'username',
            'pass'   => 'password',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Searchable Models
    |--------------------------------------------------------------------------
    |
    | The models that implement the Searchable interface. Automatically
    | import them with the provided Artisan command.
    |
    */

    'models' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Queued Indexing
    |--------------------------------------------------------------------------
    |
    | Set if you would like the search indexing to be handled by queued jobs.
    |
    */

    'queue' => [
        'created' => false,
        'updated' => false,
        'deleted' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Tubes
    |--------------------------------------------------------------------------
    |
    | Each queue connection can have different 'tubes'. This allows you to
    | balance your tubes based on priority. Sensible defaults have been
    | selected.
    |
    */

    'tubes' => [
        'created' => env('SEARCH_TUBE', 'search'),
        'updated' => env('SEARCH_TUBE', 'search'),
        'deleted' => env('SEARCH_TUBE', 'search'),
    ],

];
