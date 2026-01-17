<?php

declare(strict_types=1);

namespace Tests\Day17;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UserRegisteredTest extends TestCase
{
    #[Test]
    public function it_implements_domain_event_interface(): void {}

    #[Test]
    public function it_contains_needed_informations(): void
    {
        $event = new UserRegistered(
            userId: '12234-24555',
            email: 'email@test.org',
        );

        self::assertEquals('user_registered', $event->eventName());
        self::assertEquals('12234-24555', $event->userId());
        self::assertEquals('email@test.org', $event->email());
        self::assertEquals(new DateTimeImmutable(), $event->occurredAt());
    }
}
