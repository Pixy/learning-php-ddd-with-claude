<?php

declare(strict_types=1);

namespace App\Day04;

use App\Day01\Email;
use App\Day03\User;
use App\Day03\UserId;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;

    /**
     * @return array<int, User>
     */
    public function findAll(): array;

    public function delete(UserId $id): void;

    public function exists(Userid $id): bool;
}
