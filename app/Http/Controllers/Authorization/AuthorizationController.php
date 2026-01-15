<?php

namespace App\Http\Controllers\Authorization;

use App\Application\Authorization\Command\LoginCommand;
use App\Application\Authorization\Command\LogoutCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\AuthorizationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AuthorizationController extends Controller
{
    public function store(AuthorizationRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $token = $this->commandBus->dispatch(new LoginCommand($dto->login, $dto->password));

        return response()->json(['token' => $token]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token is missing'], 401);
        }

        $this->commandBus->dispatch(new LogoutCommand($token));

        return response()->json(['message' => 'Logged out']);
    }
}
