<?php

namespace App\Utils\Currencies;

class TurkishLira extends \App\Contracts\Utils\AbstractCurrency
{

    public static function getShortName(): string
    {
        return 'TRY';
    }
}
