<?php

declare(strict_types=1);

namespace App\Application\Employee\Command;

use App\CQRS\CommandInterface;

final readonly class UpdateEmployeeCommand implements CommandInterface
{
    public function __construct(
        public int    $id,
        public string $surname,
        public string $name,
        public string $middleName,
    )
    {
    }
}
