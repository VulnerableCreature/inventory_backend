<?php

declare(strict_types=1);

namespace App\Application\Issuance\Command;

use App\CQRS\CommandInterface;
use App\Models\Issuance;
use DateTimeImmutable;

final readonly class UpdateIssuanceIssuedAtCommand implements CommandInterface
{
    public function __construct(
        public Issuance          $issuance,
        public DateTimeImmutable $issuedAt,
    )
    {
    }
}
