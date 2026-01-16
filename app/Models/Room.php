<?php

namespace App\Models;

use App\Module\Room\Enums\RoomTypeEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int          $id
 * @property string       $name
 * @property int          $number
 * @property RoomTypeEnum $type
 * @property string       $building
 * @property int          $floor
 */
final class Room extends Model
{
    protected $table = 'rooms';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'number',
        'type',
        'building',
        'floor'
    ];

    protected function casts(): array
    {
        return [
            'type' => RoomTypeEnum::class,
        ];
    }
}
