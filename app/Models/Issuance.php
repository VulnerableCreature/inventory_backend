<?php

namespace App\Models;

use App\Module\Issuance\Enums\IssuanceStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
}
