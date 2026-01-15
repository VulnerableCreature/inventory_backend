<?php

declare(strict_types=1);

namespace App\Module\Asset\Command;

use App\Application\Asset\Command\UpdateAssetCommand;
use App\Models\Asset;
use App\Module\Asset\Exceptions\FixedAssetQuantityExceededException;
use App\Module\Asset\Exceptions\InvalidQuantityException;
use App\Shared\Exceptions\NegativeAmountException;
use App\Shared\ValueObjects\Money;
use DateInterval;

final readonly class UpdateAssetHandler
{
    /**
     * @throws InvalidQuantityException
     * @throws NegativeAmountException
     * @throws FixedAssetQuantityExceededException
     */
    public function handle(UpdateAssetCommand $command): Asset
    {
        $asset = Asset::query()->findOrFail($command->id);

        $price = Money::of($command->price);

        if ($command->quantity !== null && $command->quantity <= 0) {
            throw new InvalidQuantityException($command->quantity);
        }

        if ($command->inventoryNumber !== null) {
            $quantity = $command->quantity ?? $asset->quantity;

            if ($quantity > 1) {
                throw new FixedAssetQuantityExceededException($quantity);
            }
        }

        $asset->update([
            'original_name' => $command->originalName,
            'name' => $command->name,
            'inventory_number' => $command->inventoryNumber,
            'date_registration' => $command->dateRegistration,
            'price' => $price->getAmountInDecimal(),
            'quantity' => $command->quantity ?? $asset->quantity,
            'termination_date' => $command->dateRegistration->add(new DateInterval('P5Y'))
        ]);

        return $asset->fresh();
    }
}
