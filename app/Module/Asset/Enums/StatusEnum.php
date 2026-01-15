<?php

namespace App\Module\Asset\Enums;

enum StatusEnum: string
{
    case IN_STOCK = 'in_stock';

    case ENDED = 'ended';

    case DISPOSAL = 'disposal';

    public function label(): string
    {
        return match ($this) {
            self::IN_STOCK => 'На складе',
            self::ENDED => 'Закончился',
            self::DISPOSAL => 'Списание',
        };
    }
}
