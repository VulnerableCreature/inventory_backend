<?php

namespace App\Module\Asset\Enums;

enum AssetTypeEnum: string
{
    case FIXED = 'fixed';

    case MATERIAL = 'material';

    public function label(): string
    {
        return match ($this) {
            self::FIXED => 'Основное средство',
            self::MATERIAL => 'Материальный актив',
        };
    }
}
