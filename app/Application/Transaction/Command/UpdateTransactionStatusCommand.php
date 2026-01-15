<?php

declare(strict_types=1);

namespace App\Application\Transaction\Command;

use App\CQRS\CommandInterface;
use App\Module\Transaction\Enums\TransactionStatusEnum;

final readonly class UpdateTransactionStatusCommand implements CommandInterface
{
    public function __construct(
        public int                   $transactionId,
        public TransactionStatusEnum $status,
    )
    {
    }
}
