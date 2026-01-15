<?php

declare(strict_types=1);

namespace App\Module\User\Command;

use App\Application\User\Command\DeleteUserCommand;
use App\Models\User;

final readonly class DeleteUserHandler
{
    public function handle(DeleteUserCommand $command): void
    {
        $user = User::query()->findOrFail($command->id);

        $user->delete();
    }
}
