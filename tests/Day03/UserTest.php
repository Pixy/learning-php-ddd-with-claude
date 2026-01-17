<?php

declare(strict_types=1);

namespace Tests\Day03;

use App\Day01\Email;
use App\Day03\User;
use App\Day03\UserId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    #[Test]
    public function it_can_create_a_new_user(): void
    {
        $email = new Email('john.doe@example.com');
        $user = User::create($email, 'John Doe');

        $this->assertSame('john.doe@example.com', $user->email()->value());
        $this->assertSame('John Doe', $user->name());
        $this->assertInstanceOf(UserId::class, $user->id());
    }

    #[Test]
    public function it_generates_a_unique_id_for_each_new_user(): void
    {
        $email = new Email('john.doe@example.com');

        $user1 = User::create($email, 'John Doe');
        $user2 = User::create($email, 'John Doe');

        $this->assertFalse($user1->id()->equals($user2->id()));
    }

    #[Test]
    public function it_can_be_reconstructed_from_existing_data(): void
    {
        $id = new UserId('550e8400-e29b-41d4-a716-446655440000');
        $email = new Email('jane.doe@example.com');

        $user = User::fromExisting($id, $email, 'Jane Doe');

        $this->assertTrue($user->id()->equals($id));
        $this->assertSame('jane.doe@example.com', $user->email()->value());
        $this->assertSame('Jane Doe', $user->name());
    }

    #[Test]
    public function it_can_be_renamed(): void
    {
        $email = new Email('john.doe@example.com');
        $user = User::create($email, 'John Doe');

        $user->rename('Jonathan Doe');

        $this->assertSame('Jonathan Doe', $user->name());
    }

    #[Test]
    public function it_can_change_email(): void
    {
        $email = new Email('john.doe@example.com');
        $user = User::create($email, 'John Doe');

        $newEmail = new Email('johnny.doe@example.com');
        $user->changeEmail($newEmail);

        $this->assertSame('johnny.doe@example.com', $user->email()->value());
    }

    #[Test]
    public function two_users_with_same_id_are_equal(): void
    {
        $id = new UserId('550e8400-e29b-41d4-a716-446655440000');
        $email1 = new Email('john@example.com');
        $email2 = new Email('jane@example.com');

        $user1 = User::fromExisting($id, $email1, 'John');
        $user2 = User::fromExisting($id, $email2, 'Jane');

        $this->assertTrue($user1->equals($user2));
    }

    #[Test]
    public function two_users_with_different_id_are_not_equal(): void
    {
        $id1 = new UserId('550e8400-e29b-41d4-a716-446655440000');
        $id2 = new UserId('550e8400-e29b-41d4-a716-446655440001');
        $email = new Email('john@example.com');

        $user1 = User::fromExisting($id1, $email, 'John');
        $user2 = User::fromExisting($id2, $email, 'John');

        $this->assertFalse($user1->equals($user2));
    }

    #[Test]
    public function id_keeps_same_reference_after_modifications(): void
    {
        $email = new Email('john.doe@example.com');
        $user = User::create($email, 'John Doe');
        $originalId = $user->id();

        $user->rename('New Name');
        $user->changeEmail(new Email('new@example.com'));

        $this->assertTrue($originalId->equals($user->id()));
    }
}
