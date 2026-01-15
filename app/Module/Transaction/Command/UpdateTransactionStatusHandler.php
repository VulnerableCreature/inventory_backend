<?php

declare(strict_types=1);

namespace App\Module\Transaction\Command;

use App\Application\Transaction\Command\UpdateTransactionStatusCommand;
use App\Models\Transaction;

final readonly class UpdateTransactionStatusHandler
{
    public function handle(UpdateTransactionStatusCommand $command): void
    {
        $transaction = Transaction::query()->findOrFail($command->transactionId);
        $transaction->update([
            'status' => $command->status,
        ]);
    }
}
