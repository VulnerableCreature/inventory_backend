<?php

declare(strict_types=1);

namespace App\Module\Room\Command;

use App\Application\Room\Command\CreateRoomCommand;
use App\Models\Room;
use App\Module\Room\Exceptions\DuplicateNumberException;

final readonly class CreateRoomHandler
{
    /**
     * @throws DuplicateNumberException
     */
    public function handle(CreateRoomCommand $command): Room
    {
        $exists = Room::query()
            ->where('number', '=', $command->number)
            ->exists();

        if ($exists) {
            throw new DuplicateNumberException($command->number);
        }

        return Room::query()->create([
            'name' => $command->name,
            'number' => $command->number,
            'type' => $command->type,
            'building' => $command->building,
            'floor' => $command->floor,
        ]);
    }
}
