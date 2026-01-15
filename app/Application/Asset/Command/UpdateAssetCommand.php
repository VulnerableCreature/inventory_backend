<?php

declare(strict_types=1);

namespace App\Application\Asset\Command;

use App\CQRS\CommandInterface;
use DateTimeImmutable;

final readonly class UpdateAssetCommand implements CommandInterface
{
    public function __construct(
        public int               $id,
        public string            $originalName,
        public string            $name,
        public ?string           $inventoryNumber,
        public float             $price,
        public ?int              $quantity,
        public DateTimeImmutable $dateRegistration,
    )
    {
    }
}
