<?php

declare(strict_types=1);

namespace App\Module\Asset\Command;

use App\Application\Asset\Command\UpdateAssetQuantityCommand;
use App\Models\Asset;
use App\Module\Asset\Enums\OperationEnum;
use App\Module\Asset\Exceptions\InvalidQuantityException;

final readonly class UpdateAssetQuantityHandler
{
    /**
     * @throws InvalidQuantityException
     */
    public function handle(UpdateAssetQuantityCommand $command): Asset
    {
        $lockedAsset = Asset::query()->lockForUpdate()->findOrFail($command->asset->id);

        if ($command->operation === OperationEnum::DEBIT && $lockedAsset->quantity < $command->quantity) {
            throw new InvalidQuantityException($lockedAsset->quantity);
        }

        $newQuantity = match ($command->operation) {
            OperationEnum::CREDIT => $lockedAsset->quantity + $command->quantity,
            OperationEnum::DEBIT => $lockedAsset->quantity - $command->quantity,
        };

        $lockedAsset->update(['quantity' => $newQuantity]);

        return $lockedAsset;
    }
}
