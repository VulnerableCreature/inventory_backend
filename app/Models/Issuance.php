<?php

namespace App\Models;

use App\Module\Issuance\Enums\IssuanceStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int                   $id
 * @property int                   $creator_id
 * @property int                   $asset_id
 * @property int                   $room_id
 * @property ?int                  $device_id
 * @property int                   $issuable_id
 * @property string                $issuable_type
 * @property int                   $quantity
 * @property IssuanceStatusEnum    $status
 * @property Carbon                $issued_at
 * @property Carbon                $returned_at
 * @property string                $comment
 * @property Carbon                $created_at
 * @property Carbon                $updated_at
 *
 * @property MorphTo|User|Employee $issuable
 * @property User|BelongsTo        $creator
 * @property Asset|BelongsTo       $asset
 * @property Room|BelongsTo        $room
 * @property Asset|BelongsTo|null  $device
 */
final class Issuance extends Model
{
    protected $table = 'issuances';

    protected $fillable = [
        'creator_id',
        'asset_id',
        'room_id',
        'device_id',
        'issuable_id',
        'issuable_type',
        'quantity',
        'status',
        'issued_at',
        'returned_at',
        'comment'
    ];

    protected function casts(): array
    {
        return [
            'status' => IssuanceStatusEnum::class,
            'issued_at' => 'date',
            'returned_at' => 'date'
        ];
    }

    public function issuable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'issuable_type', 'issuable_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'device_id', 'id');
    }

    public function hasDevice(): bool
    {
        return $this->device_id !== null;
    }
}
