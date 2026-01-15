<?php

declare(strict_types=1);

namespace App\Module\Wallet\Handler;

use App\Application\Wallet\Command\UpdateWalletBalanceCommand;
use App\Models\Wallet;
use App\Module\Transaction\Enums\TransactionTypeEnum;
use App\Shared\Exceptions\CurrencyMismatchException;
use App\Shared\Exceptions\NegativeAmountException;

final readonly class UpdateWalletBalanceHandler
{
    /**
     * @throws NegativeAmountException
     * @throws CurrencyMismatchException
     */
    public function handle(UpdateWalletBalanceCommand $command): void
    {
        $wallet = Wallet::query()->lockForUpdate()->findOrFail($command->walletId);


        $balance = match ($command->type) {
            TransactionTypeEnum::CREDIT => $wallet->balance->add($command->amount),
            TransactionTypeEnum::DEBIT => $wallet->balance->subtract($command->amount),
        };

        $wallet->update([
            'balance' => $balance->getAmountInDecimal()
        ]);
    }
}
