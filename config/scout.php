<?php

return [
    'driver' => env('SCOUT_DRIVER', 'tntsearch'),

    'prefix' => env('SCOUT_PREFIX', ''),

    'queue' => env('SCOUT_QUEUE', false),

    'tntsearch' => [
        'storage'  => storage_path('app/tntsearch'),
        'fuzziness' => env('TNTSEARCH_FUZZINESS', false),
        'fuzzy' => [
            'prefix_length' => 2,
            'max_expansions' => 50,
            'distance' => 2
        ],
        'asYouType' => false,
        'searchBoolean' => env('TNTSEARCH_SEARCH_BOOLEAN', true),
    ],
];
