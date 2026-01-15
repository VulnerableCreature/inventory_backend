<?php

declare(strict_types=1);

namespace App\Module\Authorization\Handler;

use App\Application\Authorization\Command\LogoutCommand;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

final readonly class LogoutHandler
{
    public function __construct()
    {
    }

    public function handle(LogoutCommand $command): void
    {
        $token = PersonalAccessToken::findToken($command->token);

        if (!$token) {
            throw ValidationException::withMessages([
                'token' => 'Invalid or expired token'
            ])->status(401);
        }

        $token->delete();
    }
}

