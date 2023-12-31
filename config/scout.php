<?php

use App\Models\SpatialFeature;

return [

    'driver' => env('SCOUT_DRIVER', 'meilisearch'),

    'prefix' => env('SCOUT_PREFIX', ''),

    'queue' => [
        'connection' => 'redis',
        'queue' => 'scout',
    ],

    'after_commit' => false,

    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],

    'soft_delete' => false,

    'identify' => env('SCOUT_IDENTIFY', false),

    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
        'key' => env('MEILISEARCH_KEY'),
        'index-settings' => [
            SpatialFeature::class => [
                'filterableAttributes' => ['id', 'category', 'name'],
            ],
        ],
    ],

];
