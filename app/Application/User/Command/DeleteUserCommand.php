<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\CQRS\CommandInterface;

final readonly class DeleteUserCommand implements CommandInterface
{
    public function __construct(public int $id)
    {
    }
}
