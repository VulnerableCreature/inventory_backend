<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\UpdateIssuanceIssuableCommand;
use App\Models\Issuance;

final readonly class UpdateIssuanceIssuableHandler
{
    public function handle(UpdateIssuanceIssuableCommand $command): Issuance
    {
        $command->issuance->update([
            'issuable_id' => $command->issuable->getKey(),
            'issuable_type' => $command->issuable->getMorphClass()
        ]);

        return $command->issuance->fresh();
    }
}
