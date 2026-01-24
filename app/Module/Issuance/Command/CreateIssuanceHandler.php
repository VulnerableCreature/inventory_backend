<?php

declare(strict_types=1);

namespace App\Module\Issuance\Command;

use App\Application\Issuance\Command\CreateIssuanceCommand;
use App\Models\Issuance;
use App\Module\Issuance\Enums\IssuanceStatusEnum;

final readonly class CreateIssuanceHandler
{
    public function handle(CreateIssuanceCommand $command): Issuance
    {
        return Issuance::query()->create([
            'creator_id' => auth()->user()->id,
            'asset_id' => $command->asset->id,
            'room_id' => $command->room->id,
            'device_id' => $command->device?->id,
            'issuable_id' => $command->issuable->getKey(),
            'issuable_type' => $command->issuable->getMorphClass(),
            'quantity' => $command->quantity,
            'status' => IssuanceStatusEnum::ACTIVE,
            'issued_at' => $command->issued_at,
            'comment' => $command->comment
        ]);
    }
}
