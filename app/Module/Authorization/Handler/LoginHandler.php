<?php

declare(strict_types=1);

namespace App\Module\Authorization\Handler;

use App\Application\Authorization\Command\LoginCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final readonly class LoginHandler
{
    public function __construct()
    {
    }

    public function handle(LoginCommand $command): string
    {
        if (!Auth::attempt(['login' => $command->login, 'password' => $command->password])) {
            return throw ValidationException::withMessages([
                'credentials' => 'Wrong login or password'
            ])->status(401);
        }

        $user = Auth::user();

        $user->tokens()->delete();

        $token = $user->createToken('auth_token_inventory_app');

        return $token->plainTextToken;
    }
}

