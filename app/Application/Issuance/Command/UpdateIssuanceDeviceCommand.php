<?php

declare(strict_types=1);

namespace App\Application\Issuance\Command;

use App\CQRS\CommandInterface;
use App\Models\Asset;
use App\Models\Issuance;

final readonly class UpdateIssuanceDeviceCommand implements CommandInterface
{
    public function __construct(
        public Issuance $issuance,
        public Asset    $device,
    )
    {
    }
}
