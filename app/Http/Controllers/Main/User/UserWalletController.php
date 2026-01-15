<?php

namespace App\Http\Controllers\Main\User;

use App\Application\Wallet\Command\CreateWalletCommand;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class UserWalletController extends Controller
{
    public function attach(int $id): JsonResponse
    {
        $this->commandBus->dispatch(new CreateWalletCommand($id));

        return response()->json(status: 201);
    }
}
