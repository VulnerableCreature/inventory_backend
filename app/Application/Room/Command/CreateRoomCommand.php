<?php

declare(strict_types=1);

namespace App\Application\Room\Command;

use App\CQRS\CommandInterface;
use App\Module\Room\Enums\RoomTypeEnum;

final readonly class CreateRoomCommand implements CommandInterface
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
}
