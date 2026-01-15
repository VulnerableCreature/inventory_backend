<?php

declare(strict_types=1);

namespace App\Module\Wallet\Handler;

use App\Application\Wallet\Command\CreateWalletCommand;
use App\Models\User;
use App\Module\Wallet\Enums\StatusEnum;

final readonly class CreateWalletHandler
{
    private const int DEFAULT_BALANCE = 0;

    public function handle(CreateWalletCommand $command): void
    {
        $user = User::query()->findOrFail($command->userId);

        if ($user->wallet()->exists()) {
            return;
        }

        $user->wallet()->create([
            'balance' => self::DEFAULT_BALANCE,
            'status' => StatusEnum::ACTIVE,
        ]);
    }
}
