<?php

declare(strict_types=1);

namespace App\Module\RoomOccupant\Command;

use App\Application\RoomOccupant\Command\RemoveOccupantsFromRoomCommand;
use App\Models\Room;
use InvalidArgumentException;

final readonly class RemoveOccupantsFromRoomHandler
{
    public function handle(RemoveOccupantsFromRoomCommand $command): void
    {
        $room = Room::query()->findOrFail($command->roomId);

        $userIds = [];
        $employeeIds = [];


        foreach ($command->occupants as $occupant) {
            match ($occupant->type) {
                'user' => $userIds[] = $occupant->id,
                'employee' => $employeeIds[] = $occupant->id,
                default => throw new InvalidArgumentException("Invalid occupant type: $occupant->type")
            };
        }

        if (!empty($userIds)) {
            $room->users()->detach($userIds);
        }

        if (!empty($employeeIds)) {
            $room->employees()->detach($employeeIds);
        }
    }
}
