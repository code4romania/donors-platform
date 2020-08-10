<?php

declare(strict_types=1);

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel money
     |--------------------------------------------------------------------------
     */
    'locale' => config('app.locale'),
    'defaultCurrency' => config('app.currency', 'EUR'),
    'currencies' => [
        'iso' => ['EUR', 'RON', 'USD'],
    ],
];
