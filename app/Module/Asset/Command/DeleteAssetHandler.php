<?php

declare(strict_types=1);

namespace App\Module\Asset\Command;

use App\Application\Asset\Command\DeleteAssetCommand;
use App\Models\Asset;

final readonly class DeleteAssetHandler
{
    public function handle(DeleteAssetCommand $command): void
    {
        $asset = Asset::query()->findOrFail($command->id);
        $asset->delete();
    }
}
