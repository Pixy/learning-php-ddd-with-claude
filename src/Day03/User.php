<?php

declare(strict_types=1);

namespace App\Day03;

use App\Day01\Email;

final class User
{
    private function __construct(
        private UserId $id,
        private Email $email,
        private string $name
    ) {}

    public static function create(Email $email, string $name): self
    {
        return new self(
            id: UserId::generate(),
            email: $email,
            name: $name
        );
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public static function fromExisting(
        UserId $id,
        Email $email,
        string $name,
    ): self {
        return new self(
            id: $id,
            email: $email,
            name: $name
        );
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function changeEmail(Email $newEmail): void
    {
        $this->email = $newEmail;
    }

    public function equals(User $user): bool
    {
        return $this->id->equals($user->id());
    }
}
