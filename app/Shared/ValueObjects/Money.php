<?php

declare(strict_types=1);

namespace App\Shared\ValueObjects;

use App\Module\Wallet\Enums\CurrencyEnum;
use App\Shared\Exceptions\CurrencyMismatchException;
use App\Shared\Exceptions\NegativeAmountException;
use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;

final readonly class Money implements Arrayable
{
    /**
     * В копейках
     */
    private int $amount;

    /**
     * @throws NegativeAmountException
     */
    public function __construct(
        int|float|string $amount,
        private string   $currency = CurrencyEnum::RUB->value,
    )
    {
        $this->amount = $this->convertToInt($amount);

        if ($this->amount < 0) {
            throw new NegativeAmountException($this->amount);
        }
    }

    private function convertToInt(int|float|string $amount): int
    {
        if (is_int($amount)) {
            return $amount;
        }

        if (is_float($amount)) {
            return (int)round($amount * 100);
        }

        // Строка: "1234.56" или "1234,56"
        $normalized = str_replace(',', '.', (string)$amount);
        $float = (float)$normalized;
        return (int)round($float * 100);
    }

    /**
     * @throws NegativeAmountException
     */
    public static function of(int|float|string $amount, string $currency = CurrencyEnum::RUB->value): self
    {
        return new self($amount, $currency);
    }

    /**
     * @throws NegativeAmountException
     */
    public static function zero(string $currency = CurrencyEnum::RUB->value): self
    {
        return new self(0, $currency);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getAmountInDecimal(): float
    {
        return $this->amount / 100;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @throws NegativeAmountException
     * @throws CurrencyMismatchException
     */
    public function add(Money $money): self
    {
        $this->assertSameCurrency($money);
        return new self($this->amount + $money->amount, $this->currency);
    }

    /**
     * @throws NegativeAmountException
     * @throws CurrencyMismatchException
     */
    public function subtract(Money $money): self
    {
        $this->assertSameCurrency($money);
        $result = $this->amount - $money->amount;

        if ($result < 0) {
            throw new InvalidArgumentException('Result would be negative');
        }

        return new self($result, $this->currency);
    }

    /**
     * @throws NegativeAmountException
     */
    public function multiply(int|float $multiplier): self
    {
        if ($multiplier < 0) {
            throw new InvalidArgumentException('Multiplier cannot be negative');
        }

        $result = (int)round($this->amount * $multiplier);
        return new self($result, $this->currency);
    }

    /**
     * @throws NegativeAmountException
     */
    public function divide(int|float $divisor): self
    {
        if ($divisor <= 0) {
            throw new InvalidArgumentException('Divisor must be greater than zero');
        }

        $result = (int)round($this->amount / $divisor);
        return new self($result, $this->currency);
    }

    public function equals(Money $money): bool
    {
        return $this->amount === $money->amount && $this->currency === $money->currency;
    }

    /**
     * @throws CurrencyMismatchException
     */
    public function isGreaterThan(Money $money): bool
    {
        $this->assertSameCurrency($money);
        return $this->amount > $money->amount;
    }

    /**
     * @throws CurrencyMismatchException
     */
    public function isLessThan(Money $money): bool
    {
        $this->assertSameCurrency($money);
        return $this->amount < $money->amount;
    }

    public function isPositive(): bool
    {
        return $this->amount > 0;
    }

    public function isZero(): bool
    {
        return $this->amount === 0;
    }

    public function format(): string
    {
        $decimal = number_format($this->getAmountInDecimal(), 2, '.', ' ');
        return "$decimal $this->currency";
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->getAmountInDecimal(),
            'currency' => $this->currency,
        ];
    }

    /**
     * @throws CurrencyMismatchException
     */
    private function assertSameCurrency(Money $money): void
    {
        if ($this->currency !== $money->currency) {
            throw new CurrencyMismatchException(
                $this->currency,
                $money->currency,
            );
        }
    }

    /**
     * @throws NegativeAmountException
     * @throws CurrencyMismatchException
     */
    public function absoluteDifference(Money $money): self
    {
        $this->assertSameCurrency($money);
        $diff = abs($this->amount - $money->amount);
        return new self($diff, $this->currency);
    }

    public function __toString(): string
    {
        return $this->format();
    }
}
