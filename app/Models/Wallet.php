<?php

namespace App\Models;

use App\Module\User\Traits\BelongsToUserTrait;
use App\Module\Wallet\Enums\CurrencyEnum;
use App\Module\Wallet\Enums\StatusEnum;
use App\Shared\ValueObjects\Money;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int                                  $id
 * @property int                                  $user_id
 * @property Money|float                          $balance
 * @property StatusEnum                           $status
 * @property Carbon                               $created_at
 * @property Carbon                               $updated_at
 *
 * @property Collection<int, Transaction>|HasMany $transactions
 */
final class Wallet extends Model
{
    use BelongsToUserTrait;

    protected $table = 'wallets';

    protected $fillable = [
        'user_id',
        'balance',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'status' => StatusEnum::class,
        ];
    }

    public function balance(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new Money($value, CurrencyEnum::RUB->value),
            set: fn(Money|int|float|string $value) => $value instanceof Money
                ? $value->getAmountInDecimal()
                : $value,
        );
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'wallet_id', 'id');
    }
}
