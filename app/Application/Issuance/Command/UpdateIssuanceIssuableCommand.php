<?php

declare(strict_types=1);

namespace App\Application\Issuance\Command;

use App\CQRS\CommandInterface;
use App\Models\Issuance;
use Illuminate\Database\Eloquent\Model;

final readonly class UpdateIssuanceIssuableCommand implements CommandInterface
{
    public function __construct(
        public Issuance $issuance,
        public Model    $issuable,
    )
    {
    }
}
