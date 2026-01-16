<?php

declare(strict_types=1);

namespace App\Application\Room\Command;

use App\CQRS\CommandInterface;

final readonly class DeleteRoomCommand implements CommandInterface
{
    public function __construct(public int $id)
    {
    }
}
