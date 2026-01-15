<?php

declare(strict_types=1);

namespace App\Module\User\Command;

use App\Application\User\Command\CreateUserCommand;
use App\Models\User;

final readonly class CreateUserHandler
{
    public function handle(CreateUserCommand $command): User
    {
        return User::query()->createOrFirst(
            ['login' => $command->login],
            [
                'login' => $command->login,
                'password' => $command->password,
            ]
        );
    }
}
