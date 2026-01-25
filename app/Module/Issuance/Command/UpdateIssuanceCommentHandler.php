<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\UpdateIssuanceCommentCommand;
use App\Module\Issuance\Traits\ResolvableIssuableTrait;
use Exception;

final readonly class UpdateIssuanceCommentHandler
{
    use ResolvableIssuableTrait;

    /**
     * @throws Exception
     */
    public function handle(UpdateIssuanceCommentCommand $command): void
    {
        $roomLabel = $command->room->type->label();
        $roomNumber = $command->room->number;

        if ($command->asset->inventory_number === null) {
            $deviceName = $command->device?->original_name;
            $deviceInventory = $command->device?->inventory_number;

            $command->issuance->update([
                'comment' => "Установлен в $deviceName ($deviceInventory) в $roomLabel №$roomNumber"
            ]);

        }

        $issuableName = $this->resolveIssuableName($command->issuable);

        $command->issuance->update([
            'comment' => "Выдан $issuableName в $roomLabel №$roomNumber"
        ]);
    }
}
