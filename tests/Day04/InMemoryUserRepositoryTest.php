<?php

declare(strict_types=1);

namespace Tests\Day04;

use App\Day01\Email;
use App\Day03\User;
use App\Day03\UserId;
use App\Day04\InMemoryUserRepository;
use App\Day04\UserRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class InMemoryUserRepositoryTest extends TestCase
{
    private UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->repository = new InMemoryUserRepository();
    }

    #[Test]
    public function it_implements_user_repository_interface(): void
    {
        $this->assertInstanceOf(UserRepositoryInterface::class, $this->repository);
    }

    #[Test]
    public function it_can_save_and_find_a_user_by_id(): void
    {
        $user = User::create(new Email('alice@example.com'), 'Alice');

        $this->repository->save($user);

        $found = $this->repository->findById($user->id());

        $this->assertNotNull($found);
        $this->assertTrue($user->id()->equals($found->id()));
        $this->assertSame('Alice', $found->name());
    }

    #[Test]
    public function it_returns_null_when_user_not_found_by_id(): void
    {
        $nonExistentId = UserId::generate();

        $found = $this->repository->findById($nonExistentId);

        $this->assertNull($found);
    }

    #[Test]
    public function it_can_find_a_user_by_email(): void
    {
        $email = new Email('bob@example.com');
        $user = User::create($email, 'Bob');

        $this->repository->save($user);

        $found = $this->repository->findByEmail($email);

        $this->assertNotNull($found);
        $this->assertSame('Bob', $found->name());
    }

    #[Test]
    public function it_returns_null_when_user_not_found_by_email(): void
    {
        $nonExistentEmail = new Email('unknown@example.com');

        $found = $this->repository->findByEmail($nonExistentEmail);

        $this->assertNull($found);
    }

    #[Test]
    public function it_can_find_all_users(): void
    {
        $user1 = User::create(new Email('user1@example.com'), 'User 1');
        $user2 = User::create(new Email('user2@example.com'), 'User 2');

        $this->repository->save($user1);
        $this->repository->save($user2);

        $all = $this->repository->findAll();

        $this->assertCount(2, $all);
    }

    #[Test]
    public function it_returns_empty_array_when_no_users(): void
    {
        $all = $this->repository->findAll();

        $this->assertCount(0, $all);
    }

    #[Test]
    public function it_can_delete_a_user(): void
    {
        $user = User::create(new Email('delete@example.com'), 'To Delete');

        $this->repository->save($user);
        $this->assertNotNull($this->repository->findById($user->id()));

        $this->repository->delete($user->id());

        $this->assertNull($this->repository->findById($user->id()));
    }

    #[Test]
    public function delete_is_idempotent(): void
    {
        $user = User::create(new Email('idempotent@example.com'), 'Test');
        $this->repository->save($user);

        $this->repository->delete($user->id());
        $this->repository->delete($user->id());

        $this->assertNull($this->repository->findById($user->id()));
    }

    #[Test]
    public function it_can_check_if_user_exists(): void
    {
        $user = User::create(new Email('exists@example.com'), 'Exists');

        $this->assertFalse($this->repository->exists($user->id()));

        $this->repository->save($user);

        $this->assertTrue($this->repository->exists($user->id()));
    }

    #[Test]
    public function it_updates_user_when_saving_existing(): void
    {
        $user = User::create(new Email('update@example.com'), 'Original');

        $this->repository->save($user);

        $user->rename('Updated');
        $this->repository->save($user);

        $found = $this->repository->findById($user->id());

        $this->assertNotNull($found);
        $this->assertSame('Updated', $found->name());
    }

    #[Test]
    public function it_can_update_email_and_find_by_new_email(): void
    {
        $oldEmail = new Email('old@example.com');
        $newEmail = new Email('new@example.com');
        $user = User::create($oldEmail, 'User');

        $this->repository->save($user);

        $user->changeEmail($newEmail);
        $this->repository->save($user);

        $this->assertNull($this->repository->findByEmail($oldEmail));
        $this->assertNotNull($this->repository->findByEmail($newEmail));
    }

    #[Test]
    public function find_all_returns_numerically_indexed_array(): void
    {
        $user1 = User::create(new Email('a@example.com'), 'A');
        $user2 = User::create(new Email('b@example.com'), 'B');

        $this->repository->save($user1);
        $this->repository->save($user2);

        $all = $this->repository->findAll();

        $this->assertSame([0, 1], array_keys($all));
    }

    #[Test]
    public function deleted_user_is_not_in_find_all(): void
    {
        $user1 = User::create(new Email('keep@example.com'), 'Keep');
        $user2 = User::create(new Email('remove@example.com'), 'Remove');

        $this->repository->save($user1);
        $this->repository->save($user2);

        $this->repository->delete($user2->id());

        $all = $this->repository->findAll();

        $this->assertCount(1, $all);
        $this->assertTrue($user1->id()->equals($all[0]->id()));
    }

    #[Test]
    public function save_does_not_create_duplicates(): void
    {
        $user = User::create(new Email('nodupe@example.com'), 'NoDupe');

        $this->repository->save($user);
        $this->repository->save($user);
        $this->repository->save($user);

        $all = $this->repository->findAll();

        $this->assertCount(1, $all);
    }

    #[Test]
    public function find_all_returns_reindexed_array_after_delete(): void
    {
        $user1 = User::create(new Email('first@example.com'), 'First');
        $user2 = User::create(new Email('second@example.com'), 'Second');
        $user3 = User::create(new Email('third@example.com'), 'Third');

        $this->repository->save($user1);
        $this->repository->save($user2);
        $this->repository->save($user3);

        $this->repository->delete($user2->id());

        $all = $this->repository->findAll();

        $this->assertCount(2, $all);
        $this->assertSame([0, 1], array_keys($all));
    }
}
