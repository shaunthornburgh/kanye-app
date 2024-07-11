<?php

use App\Services\KanyeRestQuoteSource;

return [
    'default' => env('QUOTE_DRIVER', 'kanye_rest'),
    'default_source' => env('QUOTE_SOURCE', 'kanye_rest'),

    'drivers' => [
        'kanye_rest' => [
            'class' => KanyeRestQuoteSource::class,
        ],
    ],
];
