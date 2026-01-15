<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\CQRS\CommandInterface;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $login,
        public string $password,
    )
    {
    }
}
