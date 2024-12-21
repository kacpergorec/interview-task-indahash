<?php
declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Shared\Domain\Money;
use App\Shared\Enums\Currency;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testConstructorWithValidValue(): void
    {
        $money = new Money(100, Currency::PLN);
        $this->assertSame(100, $money->value);
        $this->assertSame(Currency::PLN, $money->currency);
    }

    public function testConstructorThrowsExceptionForNegativeValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tried to create Money with negative value');

        new Money(-100, Currency::PLN);
    }

    public function testIsEqualReturnsTrueForEqualMoney(): void
    {
        $money1 = new Money(100, Currency::PLN);
        $money2 = new Money(100, Currency::PLN);

        $this->assertTrue($money1->isEqual($money2));
    }

    public function testIsEqualReturnsFalseForDifferentValue(): void
    {
        $money1 = new Money(100, Currency::PLN);
        $money2 = new Money(200, Currency::PLN);

        $this->assertFalse($money1->isEqual($money2));
    }

    public function testIsEqualReturnsFalseForDifferentCurrency(): void
    {
        $money1 = new Money(100, Currency::PLN);
        $money2 = new Money(100, Currency::USD);

        $this->assertFalse($money1->isEqual($money2));
    }

    public function testAddReturnsNewMoneyWithSummedValue(): void
    {
        $money1 = new Money(100, Currency::PLN);
        $money2 = new Money(200, Currency::PLN);

        $result = $money1->add($money2);

        $this->assertInstanceOf(Money::class, $result);
        $this->assertSame(300, $result->value);
        $this->assertSame(Currency::PLN, $result->currency);
    }

    public function testAddThrowsExceptionForCurrencyMismatch(): void
    {
        $money1 = new Money(100, Currency::PLN);
        $money2 = new Money(200, Currency::USD);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency mismatch');

        $money1->add($money2);
    }
}
