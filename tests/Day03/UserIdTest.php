<?php

declare(strict_types=1);

namespace Tests\Day03;

use App\Day03\UserId;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UserIdTest extends TestCase
{
    #[Test]
    public function it_can_be_created_with_valid_uuid(): void
    {
        $id = new UserId('550e8400-e29b-41d4-a716-446655440000');

        $this->assertSame('550e8400-e29b-41d4-a716-446655440000', $id->value());
    }

    #[Test]
    public function it_can_generate_a_new_uuid(): void
    {
        $id = UserId::generate();

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $id->value()
        );
    }

    #[Test]
    public function it_generates_unique_ids(): void
    {
        $id1 = UserId::generate();
        $id2 = UserId::generate();

        $this->assertFalse($id1->equals($id2));
    }

    #[Test]
    public function it_throws_exception_for_invalid_uuid_format(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new UserId('invalid-uuid');
    }

    #[Test]
    public function it_throws_exception_for_empty_uuid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new UserId('');
    }

    #[Test]
    public function it_throws_exception_for_uuid_without_dashes(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new UserId('550e8400e29b41d4a716446655440000');
    }

    #[Test]
    public function two_user_ids_with_same_value_are_equal(): void
    {
        $id1 = new UserId('550e8400-e29b-41d4-a716-446655440000');
        $id2 = new UserId('550e8400-e29b-41d4-a716-446655440000');

        $this->assertTrue($id1->equals($id2));
    }

    #[Test]
    public function two_user_ids_with_different_values_are_not_equal(): void
    {
        $id1 = new UserId('550e8400-e29b-41d4-a716-446655440000');
        $id2 = new UserId('550e8400-e29b-41d4-a716-446655440001');

        $this->assertFalse($id1->equals($id2));
    }

    #[Test]
    public function it_can_be_cast_to_string(): void
    {
        $id = new UserId('550e8400-e29b-41d4-a716-446655440000');

        $this->assertSame('550e8400-e29b-41d4-a716-446655440000', (string) $id);
    }

    #[Test]
    public function it_accepts_uppercase_uuid(): void
    {
        $id = new UserId('550E8400-E29B-41D4-A716-446655440000');

        $this->assertSame('550E8400-E29B-41D4-A716-446655440000', $id->value());
    }
}
