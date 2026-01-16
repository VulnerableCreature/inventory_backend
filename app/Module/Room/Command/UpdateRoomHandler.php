<?php

declare(strict_types=1);

namespace App\Module\Room\Command;

use App\Application\Room\Command\UpdateRoomCommand;
use App\Models\Room;

final readonly class UpdateRoomHandler
{
    public function handle(UpdateRoomCommand $command): Room
    {
        $room = Room::query()->findOrFail($command->id);

        $room->update([
            'name' => $command->name,
            'number' => $command->number,
            'type' => $command->type,
            'building' => $command->building,
            'floor' => $command->floor,
        ]);

        return $room->fresh();
    }
}
