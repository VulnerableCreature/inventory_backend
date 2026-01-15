<?php

declare(strict_types=1);

namespace App\Application\Transaction\Command;

use App\CQRS\CommandInterface;
use App\Module\Transaction\Enums\TransactionTypeEnum;
use App\Shared\ValueObjects\Money;

final readonly class CreateTransactionCommand implements CommandInterface
{
    public function __construct(
        public int                 $walletId,
        public Money               $amount,
        public TransactionTypeEnum $type,
    )
    {
    }
}
