<?php


return [
    'USD' => [
        'symbol' => '$',
        'name' => 'US Dollar',
        'class' => \App\Utils\Currencies\USDollar::class,
        'format' => [
            'precision' => 2,
            'thousand' => ',',
            'decimal' => '.',
            'symbol_first' => true,
        ]
    ],
    'EUR' => [
        'symbol' => '€',
        'name' => 'Euro',
        'class' => \App\Utils\Currencies\Euro::class,
        'format' => [
            'precision' => 2,
            'thousand' => '.',
            'decimal' => ',',
            'symbol_first' => false,
        ]
    ],
    'TRY' => [
        'symbol' => '₺',
        'name' => 'Turkish Lira',
        'class' => \App\Utils\Currencies\TurkishLira::class,
        'format' => [
            'precision' => 2,
            'thousand' => '.',
            'decimal' => ',',
            'symbol_first' => true,
        ]
    ],
];
