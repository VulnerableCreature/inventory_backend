<?php

namespace App\Module\Transaction\Enums;

enum TransactionTypeEnum: string
{
    case CREDIT = 'credit';

    case DEBIT = 'debit';

    public function label(): string
    {
        return match ($this) {
            self::CREDIT => 'Пополнение',
            self::DEBIT => 'Списание',
        };
    }
}
