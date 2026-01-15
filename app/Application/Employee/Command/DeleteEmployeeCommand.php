<?php

declare(strict_types=1);

namespace App\Application\Employee\Command;

use App\CQRS\CommandInterface;

final readonly class DeleteEmployeeCommand implements CommandInterface
{
    public function __construct(
        public int $id,
    )
    {
    }
}
