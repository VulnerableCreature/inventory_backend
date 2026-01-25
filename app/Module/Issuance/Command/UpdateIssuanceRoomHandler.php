<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\UpdateIssuanceRoomCommand;

final readonly class UpdateIssuanceRoomHandler
{
    public function handle(UpdateIssuanceRoomCommand $command): void
    {
        $command->issuance->update([
            'room_id' => $command->room->id
        ]);
    }
}
