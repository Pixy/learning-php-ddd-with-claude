<?php

declare(strict_types=1);

namespace Tests\Day02;

use App\Day02\Money;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase
{
    #[Test]
    public function it_can_be_created_with_amount_and_currency(): void
    {
        $money = new Money(1000, 'EUR');

        $this->assertSame(1000, $money->amount());
        $this->assertSame('EUR', $money->currency());
    }

    #[Test]
    public function it_can_add_two_money_with_same_currency(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(500, 'EUR');

        $result = $money1->add($money2);

        $this->assertSame(1500, $result->amount());
        $this->assertSame('EUR', $result->currency());
    }

    #[Test]
    public function it_returns_a_new_instance_when_adding(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(500, 'EUR');

        $result = $money1->add($money2);

        $this->assertNotSame($money1, $result);
        $this->assertNotSame($money2, $result);
    }

    #[Test]
    public function it_throws_exception_when_adding_different_currencies(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(500, 'USD');

        $this->expectException(InvalidArgumentException::class);

        $money1->add($money2);
    }

    #[Test]
    public function it_can_subtract_two_money_with_same_currency(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(300, 'EUR');

        $result = $money1->subtract($money2);

        $this->assertSame(700, $result->amount());
        $this->assertSame('EUR', $result->currency());
    }

    #[Test]
    public function it_can_have_negative_amount_after_subtraction(): void
    {
        $money1 = new Money(300, 'EUR');
        $money2 = new Money(1000, 'EUR');

        $result = $money1->subtract($money2);

        $this->assertSame(-700, $result->amount());
    }

    #[Test]
    public function it_throws_exception_when_subtracting_different_currencies(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(500, 'USD');

        $this->expectException(InvalidArgumentException::class);

        $money1->subtract($money2);
    }

    #[Test]
    public function it_can_multiply_by_a_factor(): void
    {
        $money = new Money(1000, 'EUR');

        $result = $money->multiply(2.5);

        $this->assertSame(2500, $result->amount());
        $this->assertSame('EUR', $result->currency());
    }

    #[Test]
    public function it_rounds_down_when_multiplying(): void
    {
        $money = new Money(100, 'EUR');

        $result = $money->multiply(1.999);

        $this->assertSame(199, $result->amount());
    }

    #[Test]
    public function it_rounds_down_when_multiplying_negative_amounts(): void
    {
        // -100 * 1.999 = -199.9, arrondi à l'entier inférieur = -200 (pas -199)
        $money = new Money(-100, 'EUR');

        $result = $money->multiply(1.999);

        $this->assertSame(-200, $result->amount());
    }

    #[Test]
    public function it_returns_a_new_instance_when_multiplying(): void
    {
        $money = new Money(1000, 'EUR');

        $result = $money->multiply(2);

        $this->assertNotSame($money, $result);
    }

    #[Test]
    public function two_money_with_same_amount_and_currency_are_equal(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(1000, 'EUR');

        $this->assertTrue($money1->equals($money2));
    }

    #[Test]
    public function two_money_with_different_amounts_are_not_equal(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(500, 'EUR');

        $this->assertFalse($money1->equals($money2));
    }

    #[Test]
    public function two_money_with_different_currencies_are_not_equal(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(1000, 'USD');

        $this->assertFalse($money1->equals($money2));
    }

    #[Test]
    public function it_can_check_if_greater_than(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(500, 'EUR');

        $this->assertTrue($money1->isGreaterThan($money2));
        $this->assertFalse($money2->isGreaterThan($money1));
    }

    #[Test]
    public function it_throws_exception_when_comparing_greater_than_with_different_currencies(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(500, 'USD');

        $this->expectException(InvalidArgumentException::class);

        $money1->isGreaterThan($money2);
    }

    #[Test]
    public function it_can_check_if_less_than(): void
    {
        $money1 = new Money(500, 'EUR');
        $money2 = new Money(1000, 'EUR');

        $this->assertTrue($money1->isLessThan($money2));
        $this->assertFalse($money2->isLessThan($money1));
    }

    #[Test]
    public function it_throws_exception_when_comparing_less_than_with_different_currencies(): void
    {
        $money1 = new Money(500, 'EUR');
        $money2 = new Money(1000, 'USD');

        $this->expectException(InvalidArgumentException::class);

        $money1->isLessThan($money2);
    }

    #[Test]
    public function equal_amounts_are_not_greater_or_less_than(): void
    {
        $money1 = new Money(1000, 'EUR');
        $money2 = new Money(1000, 'EUR');

        $this->assertFalse($money1->isGreaterThan($money2));
        $this->assertFalse($money1->isLessThan($money2));
    }
}
