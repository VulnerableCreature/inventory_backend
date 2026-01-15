<?php

declare(strict_types=1);

namespace App\Module\Transaction\Command;

use App\Application\Transaction\Command\CreateTransactionCommand;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Module\Transaction\Enums\TransactionStatusEnum;
use App\Module\Transaction\Enums\TransactionTypeEnum;
use App\Shared\Exceptions\CurrencyMismatchException;
use App\Shared\Exceptions\NegativeAmountException;

final readonly class CreateTransactionHandler
{
    /**
     * @throws NegativeAmountException
     * @throws CurrencyMismatchException
     */
    public function handle(CreateTransactionCommand $command): Transaction
    {
        $wallet = Wallet::query()->findOrFail($command->walletId);

        $balanceAfter = match ($command->type) {
            TransactionTypeEnum::CREDIT => $wallet->balance->add($command->amount),
            TransactionTypeEnum::DEBIT => $wallet->balance->subtract($command->amount),
        };

        return Transaction::query()->create([
            'wallet_id' => $wallet->id,
            'type' => $command->type,
            'amount' => $command->amount,
            'balance_before' => $wallet->balance,
            'balance_after' => $balanceAfter,
            'status' => TransactionStatusEnum::PENDING,
        ]);
    }
}
