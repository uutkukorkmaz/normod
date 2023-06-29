<?php

namespace App\Utils\Currencies;

use App\Contracts\Utils\AbstractCurrency;

class USDollar extends AbstractCurrency
{

    public static function getShortName(): string
    {
        return 'USD';
    }
}
