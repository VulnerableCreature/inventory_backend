<?php

declare(strict_types=1);

namespace App\Module\Room\Command;

use App\Application\Room\Command\DeleteRoomCommand;
use App\Models\Room;

final readonly class DeleteRoomHandler
{
    public function handle(DeleteRoomCommand $command): void
    {
        $room = Room::query()->findOrFail($command->id);
        $room->delete();
    }
}
