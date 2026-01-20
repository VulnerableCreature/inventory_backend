<?php

declare(strict_types=1);

namespace App\Application\RoomOccupant\Command;

use App\CQRS\CommandInterface;
use App\Module\RoomOccupant\Entity\OccupantEntity;

final readonly class RemoveOccupantsFromRoomCommand implements CommandInterface
{
    /**
     * @param array|OccupantEntity[] $occupants
     */
    public function __construct(
        public int   $roomId,
        public array $occupants,
    )
    {
    }
}
