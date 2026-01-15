<?php

declare(strict_types=1);

namespace App\Application\Asset\Command;

use App\CQRS\CommandInterface;

final readonly class DeleteAssetCommand implements CommandInterface
{
    public function __construct(public int $id)
    {
    }
}
