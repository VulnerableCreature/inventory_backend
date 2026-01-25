<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\UpdateIssuanceQuantityCommand;

final readonly class UpdateIssuanceQuantityHandler
{
    public function handle(UpdateIssuanceQuantityCommand $command): void
    {
        $command->issuance->update([
            'quantity' => $command->quantity
        ]);
    }
}
