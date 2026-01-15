<?php

namespace App\Http\Controllers\Main\Wallet;

use App\Application\Wallet\Query\GetWalletByIdQuery;
use App\Http\Controllers\Controller;
use App\Http\Resources\Wallet\WalletResource;

final class WalletController extends Controller
{
    public function show(int $id): WalletResource
    {
        $wallet = $this->queryBus->ask(new GetWalletByIdQuery($id));

        return new WalletResource($wallet);
    }
}
