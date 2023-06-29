<?php

namespace App\Utils;

use App\Contracts\Utils\AbstractCurrency;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Currency implements Castable
{

    /**
     * @throws Exception
     */
    public static function make(string $currency,float $amount=0): AbstractCurrency
    {
        if (array_key_exists($currency, config('currency'))) {
            $currency = config('currency.' . $currency . '.class');
        }

        if (!class_exists($currency) || !is_subclass_of($currency, AbstractCurrency::class)) {
            throw new Exception('Invalid currency');
        }

        return resolve($currency)->setAmount($amount);
    }


    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class implements CastsAttributes {
            public function get(Model $model, string $key, mixed $value, array $attributes)
            {
                return Currency::make($model->currency ?? config('app.currency'), $value);
            }

            public function set(Model $model, string $key, mixed $value, array $attributes): array
            {
                return [
                    $key => $value,
                    'currency' => $attributes['currency'] ?? config('app.currency')
                ];
            }
        };
    }
}
