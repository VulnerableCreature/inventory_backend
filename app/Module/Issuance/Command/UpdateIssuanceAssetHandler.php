<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\UpdateIssuanceAssetCommand;

final readonly class UpdateIssuanceAssetHandler
{
    public function handle(UpdateIssuanceAssetCommand $command): void
    {
        $command->issuance->update([
            'asset_id' => $command->asset->id
        ]);
    }
}
