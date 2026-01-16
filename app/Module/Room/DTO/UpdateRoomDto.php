<?php

declare(strict_types=1);

namespace App\Module\Room\DTO;

use App\Module\Room\Enums\RoomTypeEnum;
use Illuminate\Support\Arr;

final readonly class UpdateRoomDto
{
    public function __construct(
        public string       $name,
        public int          $number,
        public RoomTypeEnum $type,
        public string       $building,
        public int          $floor,
    )
    {
    }

    public static function fromRequest(array $data): UpdateRoomDto
    {
        return new self(
            Arr::get($data, 'name'),
            Arr::get($data, 'number'),
            RoomTypeEnum::from(Arr::get($data, 'type')),
            Arr::get($data, 'building'),
            Arr::get($data, 'floor'),
        );
    }
}
