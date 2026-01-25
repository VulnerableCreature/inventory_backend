<?php

declare(strict_types=1);

namespace App\Module\Asset\Command;

use App\Application\Asset\Command\UpdateAssetStatusCommand;
use App\Models\Asset;
use App\Module\Asset\Enums\StatusEnum;

final readonly class UpdateAssetStatusHandler
{
    public function handle(UpdateAssetStatusCommand $command): Asset
    {
        $asset = $command->asset;

        if ($asset->quantity === 0 && $asset->status !== StatusEnum::ENDED) {
            $asset->update([
                'status' => StatusEnum::ENDED
            ]);
        }

        if ($asset->quantity > 0 && $asset->status === StatusEnum::ENDED) {
            $asset->update([
                'status' => StatusEnum::IN_STOCK
            ]);
        }

        return $asset;
    }
}
