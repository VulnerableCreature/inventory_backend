<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\UpdateIssuanceDeviceCommand;

final readonly class UpdateIssuanceDeviceHandler
{
    public function handle(UpdateIssuanceDeviceCommand $command): void
    {
        $command->issuance->update([
            'device_id' => $command->device->id
        ]);
    }
}
