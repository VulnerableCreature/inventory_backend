<?php

declare(strict_types=1);

namespace App\Application\Issuance\Command;

use App\CQRS\CommandInterface;
use App\Models\Issuance;

final readonly class UpdateIssuanceQuantityCommand implements CommandInterface
{
    public function __construct(
        public Issuance $issuance,
        public int      $quantity,
    )
    {
    }
}
