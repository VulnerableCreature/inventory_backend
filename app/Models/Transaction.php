<?php

namespace App\Models;

use App\Module\Transaction\Enums\TransactionStatusEnum;
use App\Module\Transaction\Enums\TransactionTypeEnum;
use App\Module\Wallet\Enums\CurrencyEnum;
use App\Shared\ValueObjects\Money;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int                   $id
 * @property int                   $wallet_id
 * @property TransactionTypeEnum   $type
 * @property Money|float           $amount
 * @property Money|float           $balance_before
 * @property Money|float           $balance_after
 * @property TransactionStatusEnum $status
 * @property Carbon                $created_at
 * @property Carbon                $updated_at
 */
final class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'balance_before' => 'decimal:2',
            'balance_after' => 'decimal:2',
            'type' => TransactionTypeEnum::class,
            'status' => TransactionStatusEnum::class,
        ];
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new Money($value, CurrencyEnum::RUB->value),
            set: fn(Money|int|float|string $value) => $value instanceof Money
                ? $value->getAmountInDecimal()
                : $value,
        );
    }

    public function balanceBefore(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new Money($value, CurrencyEnum::RUB->value),
            set: fn(Money|int|float|string $value) => $value instanceof Money
                ? $value->getAmountInDecimal()
                : $value,
        );
    }

    public function balanceAfter(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new Money($value, CurrencyEnum::RUB->value),
            set: fn(Money|int|float|string $value) => $value instanceof Money
                ? $value->getAmountInDecimal()
                : $value,
        );
    }
}
