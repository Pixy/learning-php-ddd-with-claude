<?php

declare(strict_types=1);

namespace App\Day05;

use App\Day01\Email;
use App\Day03\User;
use App\Day03\UserId;
use App\Day04\UserRepositoryInterface;
use Exception;
use PDO;

final class PostgresUserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly PDO $pdo) {}

    public function save(User $newUser): void
    {

        $query = $this->pdo->prepare(
            'INSERT INTO users (id, email, name) VALUES (:id, :email, :name)
            ON CONFLICT(id) DO UPDATE 
            SET email = excluded.email, name = excluded.name'
        );
        $query->execute([
            'id' => (string) $newUser->id(),
            'email' => (string) $newUser->email(),
            'name' => $newUser->name()
        ]);
    }

    public function findById(UserId $id): ?User
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $query->execute(['id' => (string) $id]);
        $result = $query->fetchAll();

        if (count($result) === 0) {
            return null;
        }

        $user = $result[0];
        return User::fromExisting(
            new UserId($user['id']),
            new Email($user['email']),
            $user['name']
        );
    }

    public function findByEmail(Email $email): ?User
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $query->execute(['email' => (string) $email]);
        $result = $query->fetchAll();

        if (count($result) === 0) {
            return null;
        }

        $user = $result[0];
        return User::fromExisting(
            new UserId($user['id']),
            new Email($user['email']),
            $user['name']
        );
    }

    public function findAll(): array
    {
        $query = $this->pdo->prepare('SELECT * FROM users');
        $query->execute();
        $result = $query->fetchAll();

        if (count($result) === 0) {
            return [];
        }

        return array_map(fn($user) =>
        User::fromExisting(
            new UserId($user['id']),
            new Email($user['email']),
            $user['name']
        ), $result);
    }

    public function delete(UserId $id): void
    {
        $query = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $query->execute(['id' => (string) $id]);
    }

    public function exists(Userid $id): bool
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $query->execute(['id' => (string) $id]);
        $result = $query->fetchAll();

        return count($result) >= 1;
    }

    public function createTable(): void
    {
        try {
            $query = $this->pdo->prepare(
                'CREATE TABLE IF NOT EXISTS users (
                    id UUID PRIMARY KEY,
                    email VARCHAR(255) UNIQUE NOT NULL,
                    name VARCHAR(255) NOT NULL
                )'
            );
            $query->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
