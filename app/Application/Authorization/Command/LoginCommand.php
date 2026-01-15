<?php

declare(strict_types=1);

namespace App\Application\Authorization\Command;

use App\CQRS\CommandInterface;

final class LoginCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public string $password,
    )
    {
    }
}
