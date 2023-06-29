<?php

namespace App\Utils\Currencies;

class Euro extends \App\Contracts\Utils\AbstractCurrency
{

    public static function getShortName(): string
    {
        return 'EUR';
    }
}
