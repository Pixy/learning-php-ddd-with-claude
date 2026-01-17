<?php

declare(strict_types=1);

namespace App\Day04;

use App\Day01\Email;
use App\Day03\User;
use App\Day03\UserId;

final class InMemoryUserRepository implements UserRepositoryInterface
{
    /**
     * @var array<int, User> $users
     */
    private array $users = [];

    public function save(User $newUser): void
    {
        foreach ($this->users as $key => $user) {
            if ($user->id()->equals($newUser->id())) {
                $this->users[$key] = $newUser;

                return;
            }
        }

        $this->users[] = $newUser;
    }

    public function findById(UserId $id): ?User
    {
        foreach ($this->users as $user) {
            if ($user->id()->equals($id)) {
                return $user;
            }
        }

        return null;
    }

    public function findByEmail(Email $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->email()->equals($email)) {
                return $user;
            }
        }

        return null;
    }

    public function findAll(): array
    {
        return $this->users;
    }

    public function delete(UserId $id): void
    {
        $this->users = array_values(
            array_filter($this->users, fn(User $user) => !$user->id()->equals($id))
        );
    }

    public function exists(Userid $id): bool
    {
        return $this->findById($id) !== null;
    }
}
