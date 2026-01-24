<?php

declare(strict_types=1);

namespace App\Application\Asset\Command;

use App\CQRS\CommandInterface;
use App\Models\Asset;

final readonly class UpdateAssetStatusCommand implements CommandInterface
{
    public function __construct(
        public Asset $asset,
    )
    {
    }
}
