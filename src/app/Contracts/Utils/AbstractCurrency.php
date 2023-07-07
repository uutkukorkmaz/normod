<?php

namespace App\Contracts\Utils;

use App\Utils\Currency;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

abstract class AbstractCurrency
{

    protected array $config;

    public function __construct(protected float $amount = 0)
    {
        $this->config = config('currency.' . static::getShortName());
    }

    public function getName(): string
    {
        return $this->config['name'];
    }

    public function getSymbol(): string
    {
        return $this->config['symbol'];
    }

    public function getPrecision(): int
    {
        return $this->config['format']['precision'];
    }

    public function getDecimalSeparator(): string
    {
        return $this->config['format']['decimal'];
    }

    public function getThousandSeparator(): string
    {
        return $this->config['format']['thousand'];
    }

    public function setAmount(float $amount): AbstractCurrency
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function format(): string
    {
        $amount = number_format(
            $this->amount / 100,
            $this->getPrecision(),
            $this->getDecimalSeparator(),
            $this->getThousandSeparator()
        );

        return $this->config['format']['symbol_first']
            ? $this->getSymbol() . $amount
            : $amount . $this->getSymbol();
    }

    public function convert(string $to): AbstractCurrency
    {
        $to = Currency::make($to);

        return $to->setAmount($this->getAmount() / ($this->getRate($to)));
    }

    protected function getRate(AbstractCurrency $to): float
    {
        $rates = Http::get('https://api.exchangerate-api.com/v4/latest/' . $to->getShortName())->json();

        return $rates['rates'][$this->getShortName()] ?? 1;
    }

    public function isEquals(AbstractCurrency $to): bool
    {
        return $this->getAmount() === $to->convert(static::class)->getAmount();
    }

    public function multiply($multiplier)
    {
        $this->setAmount($this->getAmount() * $multiplier);

        return $this;
    }

    public function __toString(): string
    {
        return $this->format();
    }

    abstract public static function getShortName(): string;
}
