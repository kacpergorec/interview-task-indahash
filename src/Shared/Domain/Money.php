<?php
declare (strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Enums\Currency;

readonly class
Money
{
    public function __construct(
        public int    $value,
        public Currency $currency = Currency::PLN
    )
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Tried to create Money with negative value');
        }
    }

    public function isEqual(Money $money): bool
    {
        return (
            $this->value === $money->value &&
            $this->currency === $money->currency
        );
    }

    public function add(Money $money): Money
    {
        $this->validateCurrency($money->currency);

        return new Money(
            value: $this->value + $money->value,
            currency: $this->currency
        );
    }

    public function validateCurrency(Currency $currency): void
    {
        if ($this->currency !== $currency) {
            throw new \InvalidArgumentException('Currency mismatch');
        }
    }
}
