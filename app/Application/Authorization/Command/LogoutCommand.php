<?php

declare(strict_types=1);

namespace App\Application\Authorization\Command;

use App\CQRS\CommandInterface;

final class LogoutCommand implements CommandInterface
{
    public function __construct(
        public string $token,
    )
    {
    }
}
