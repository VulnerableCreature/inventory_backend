<?php

namespace App\Module\Transaction\Enums;

enum TransactionStatusEnum: string
{
    case PENDING = 'pending';

    case COMPLETED = 'completed';

    case FAILED = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'В ожидании',
            self::COMPLETED => 'Завершено',
            self::FAILED => 'Ошибка',
        };
    }
}
