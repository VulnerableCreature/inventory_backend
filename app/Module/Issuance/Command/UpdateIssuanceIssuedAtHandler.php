<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\UpdateIssuanceIssuedAtCommand;

final readonly class UpdateIssuanceIssuedAtHandler
{
    public function handle(UpdateIssuanceIssuedAtCommand $command): void
    {
        $command->issuance->update([
            'issued_at' => $command->issuedAt
        ]);
    }
}
