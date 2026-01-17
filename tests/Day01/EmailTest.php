<?php

declare(strict_types=1);

namespace Tests\Day01;

use App\Day01\Email;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    #[Test]
    public function it_can_be_created_with_a_valid_email(): void
    {
        $email = new Email('john.doe@example.com');

        $this->assertInstanceOf(Email::class, $email);
    }

    #[Test]
    public function it_returns_the_email_value(): void
    {
        $email = new Email('john.doe@example.com');

        $this->assertSame('john.doe@example.com', $email->value());
    }

    #[Test]
    public function it_can_be_cast_to_string(): void
    {
        $email = new Email('john.doe@example.com');

        $this->assertSame('john.doe@example.com', (string) $email);
    }

    #[Test]
    #[DataProvider('invalidEmailsProvider')]
    public function it_throws_an_exception_for_invalid_emails(string $invalidEmail): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Email($invalidEmail);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function invalidEmailsProvider(): array
    {
        return [
            'empty string' => [''],
            'no at sign' => ['johndoe.example.com'],
            'no domain' => ['johndoe@'],
            'no local part' => ['@example.com'],
            'spaces' => ['john doe@example.com'],
            'double at' => ['john@@example.com'],
        ];
    }

    #[Test]
    public function two_emails_with_same_value_are_equal(): void
    {
        $email1 = new Email('john.doe@example.com');
        $email2 = new Email('john.doe@example.com');

        $this->assertTrue($email1->equals($email2));
    }

    #[Test]
    public function two_emails_with_different_values_are_not_equal(): void
    {
        $email1 = new Email('john.doe@example.com');
        $email2 = new Email('jane.doe@example.com');

        $this->assertFalse($email1->equals($email2));
    }

    #[Test]
    public function it_normalizes_email_to_lowercase(): void
    {
        $email = new Email('John.Doe@Example.COM');

        $this->assertSame('john.doe@example.com', $email->value());
    }

    #[Test]
    public function it_extracts_the_domain(): void
    {
        $email = new Email('john.doe@example.com');

        $this->assertSame('example.com', $email->domain());
    }

    #[Test]
    public function it_extracts_the_local_part(): void
    {
        $email = new Email('john.doe@example.com');

        $this->assertSame('john.doe', $email->localPart());
    }
}
