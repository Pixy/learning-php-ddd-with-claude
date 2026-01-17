<?php

declare(strict_types=1);

namespace App\Day03;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class UserId
{
    public function __construct(private readonly string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException('Bad UUID');
        }
    }

    public function value(): string
    {
        return $this->id;
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function equals(UserId $id): bool
    {
        return $this->id === $id->value();
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
