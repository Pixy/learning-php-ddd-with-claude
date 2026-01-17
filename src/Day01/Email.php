<?php

declare(strict_types=1);

namespace App\Day01;

use InvalidArgumentException;

// TODO: Implement the Email value object
// Run tests with: docker compose run --rm php vendor/bin/phpunit tests/Day01
final class Email
{
    public function __construct(private readonly string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException();
        }
    }

    public function value(): string
    {
        return strtolower($this->email);
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function equals(Email $email): bool
    {
        return $this->email === $email->value();
    }

    public function domain(): string
    {
        return explode('@', $this->value())[1];
    }

    public function localPart(): string
    {
        return explode('@', $this->value())[0];
    }
}
