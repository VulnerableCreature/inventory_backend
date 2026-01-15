<?php

namespace App\Models;

use App\Module\Asset\Enums\AssetTypeEnum;
use App\Module\Asset\Enums\StatusEnum;
use App\Module\User\Traits\BelongsToUserTrait;
use App\Module\Wallet\Enums\CurrencyEnum;
use App\Shared\ValueObjects\Money;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int           $id
 * @property int           $user_id
 * @property string        $original_name
 * @property string        $name
 * @property ?string       $inventory_number
 * @property StatusEnum    $status
 * @property Carbon        $date_registration
 * @property Money|float   $price
 * @property int           $quantity
 * @property Carbon        $termination_date
 * @property Carbon        $created_at
 * @property Carbon        $updated_at
 *
 * @property AssetTypeEnum $type
 *
 * @method static Builder fixed()
 * @method static Builder material()
 */
final class Asset extends Model
{
    use BelongsToUserTrait;

    protected $table = 'assets';

    protected $fillable = [
        'user_id',
        'original_name',
        'name',
        'inventory_number',
        'status',
        'date_registration',
        'price',
        'quantity',
        'termination_date'
    ];

    protected function casts(): array
    {
        return [
            'date_registration' => 'immutable_date',
            'termination_date' => 'immutable_date',
            'price' => 'decimal:2',
            'status' => StatusEnum::class,
        ];
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new Money($value, CurrencyEnum::RUB->value),
            set: fn(Money|int|float|string $value) => $value instanceof Money
                ? $value->getAmountInDecimal()
                : $value,
        );
    }

    public function scopeFixed(Builder $query): Builder
    {
        return $query->whereNotNull('inventory_number');
    }

    public function scopeMaterial(Builder $query): Builder
    {
        return $query->whereNull('inventory_number');
    }

    public function isFixedAsset(): bool
    {
        return $this->inventory_number !== null;
    }

    public function isMaterialAsset(): bool
    {
        return $this->inventory_number === null;
    }

    public function getTypeAttribute(): AssetTypeEnum
    {
        return $this->isFixedAsset()
            ? AssetTypeEnum::FIXED
            : AssetTypeEnum::MATERIAL;
    }
}
