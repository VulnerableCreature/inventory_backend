<?php

declare(strict_types=1);

namespace App\Application\Wallet\Command;

use App\CQRS\CommandInterface;

final readonly class CreateWalletCommand implements CommandInterface
{
    public function __construct(public int $userId)
    {
    }
}
