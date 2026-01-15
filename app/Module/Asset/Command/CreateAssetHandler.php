<?php

declare(strict_types=1);

namespace App\Module\Asset\Command;

use App\Application\Asset\Command\CreateAssetCommand;
use App\Models\Asset;
use App\Module\Asset\Enums\StatusEnum;
use App\Module\Asset\Exceptions\DuplicateInventoryNumberException;
use App\Module\Asset\Exceptions\FixedAssetQuantityExceededException;
use App\Module\Asset\Exceptions\InvalidQuantityException;
use App\Shared\Exceptions\NegativeAmountException;
use App\Shared\ValueObjects\Money;
use DateInterval;

final readonly class CreateAssetHandler
{
    /**
     * @throws DuplicateInventoryNumberException
     * @throws InvalidQuantityException
     * @throws NegativeAmountException
     * @throws FixedAssetQuantityExceededException
     */
    public function handle(CreateAssetCommand $command): Asset
    {
        $price = Money::of($command->price);

        if ($command->quantity <= 0) {
            throw new InvalidQuantityException($command->quantity);
        }

        if ($command->inventoryNumber !== null) {
            $exists = Asset::query()
                ->where('inventory_number', '=', $command->inventoryNumber)
                ->exists();

            if ($exists) {
                throw new DuplicateInventoryNumberException($command->inventoryNumber);
            }

            if ($command->quantity > 1) {
                throw new FixedAssetQuantityExceededException($command->quantity);
            }
        }

        return Asset::query()->create([
            'user_id' => auth()->user()->id,
            'original_name' => $command->originalName,
            'name' => $command->name,
            'inventory_number' => $command->inventoryNumber,
            'date_registration' => $command->dateRegistration,
            'status' => StatusEnum::IN_STOCK,
            'price' => $price->getAmountInDecimal(),
            'quantity' => $command->quantity,
            'termination_date' => $command->dateRegistration->add(new DateInterval('P5Y'))
        ]);
    }
}
