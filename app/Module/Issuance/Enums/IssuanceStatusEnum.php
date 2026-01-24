<?php

namespace App\Module\Issuance\Enums;

enum IssuanceStatusEnum: string
{
    case ACTIVE = 'active';

    case RETURNED = 'returned';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Активно',
            self::RETURNED => 'Возвращено',
        };
    }
}
