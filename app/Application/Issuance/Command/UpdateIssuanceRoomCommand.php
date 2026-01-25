<?php

declare(strict_types=1);

namespace App\Application\Issuance\Command;

use App\CQRS\CommandInterface;
use App\Models\Issuance;
use App\Models\Room;

final readonly class UpdateIssuanceRoomCommand implements CommandInterface
{
    public function __construct(
        public Issuance $issuance,
        public Room     $room,
    )
    {
    }
}
