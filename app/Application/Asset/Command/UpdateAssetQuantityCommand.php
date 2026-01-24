<?php

declare(strict_types=1);

namespace App\Application\Asset\Command;

use App\CQRS\CommandInterface;
use App\Models\Asset;
use App\Module\Asset\Enums\OperationEnum;

final readonly class UpdateAssetQuantityCommand implements CommandInterface
{
    public function __construct(
        public Asset         $asset,
        public int           $quantity,
        public OperationEnum $operation,
    )
    {
    }
}
