<?php

declare(strict_types=1);

namespace App\Day02;

use InvalidArgumentException;

final class Money
{
    public function __construct(
        private readonly int $amount,
        private readonly string $currency
    ) {}

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function add(Money $money): self
    {
        $this->checkSameCurrency($money->currency());

        return new Money($this->amount + $money->amount(), $this->currency);
    }

    public function subtract(Money $money): self
    {
        $this->checkSameCurrency($money->currency());

        return new Money($this->amount - $money->amount(), $this->currency);
    }

    public function multiply(float $factor): self
    {
        $newAmount = ($this->amount * $factor);
        $roundedAmount = (int) floor($newAmount);

        return new Money($roundedAmount, $this->currency);
    }

    public function equals(Money $money): bool
    {
        try {
            $this->checkSameCurrency($money->currency());
        } catch (InvalidArgumentException) {
            return false;
        }

        return $this->amount === $money->amount();
    }

    public function isGreaterThan(Money $money): bool
    {
        $this->checkSameCurrency($money->currency());

        return $this->amount > $money->amount();
    }

    public function isLessThan(Money $money): bool
    {
        $this->checkSameCurrency($money->currency());

        return $this->amount < $money->amount();
    }

    private function checkSameCurrency(string $currency2): void
    {
        if ($this->currency !== $currency2) {
            throw new InvalidArgumentException('Cannot compare different currencies');
        }
    }
}
